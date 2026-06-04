<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisitRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VisitRequestController extends Controller
{
    public function index()
    {
        $visitRequests = VisitRequest::with(['visitSchedule', 'timeSlot', 'companions', 'confirmation'])
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('admin.visit-requests', [
            'visitRequests' => $visitRequests,
            'totalRequests' => VisitRequest::count(),
            'approvedRequests' => VisitRequest::where('status', 'approved')->count(),
            'cancelledRequests' => VisitRequest::whereIn('status', ['cancelled_by_visitor', 'cancelled_by_admin'])->count(),
            'completedRequests' => VisitRequest::where('status', 'completed')->count(),
        ]);
    }

    public function update(Request $request, VisitRequest $visitRequest)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:approved,cancelled_by_visitor,cancelled_by_admin,completed,no_show'],
        ]);

        $visitRequest->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('admin.visit-requests')
            ->with('success', 'Барањето за посета е ажурирано.');
    }

    public function searchVisit(Request $request)
    {
        $code = trim((string) $request->query('code', ''));

        $visitRequest = null;
        $searchError = null;

        if ($code !== '') {
            $visitRequest = $this->findVisitByCode($code);

            if (! $visitRequest || ! $visitRequest->confirmation) {
                $searchError = 'Не е пронајдена посета за внесениот код.';
            } else {
                $pdfPath = (string) ($visitRequest->confirmation->pdf_url ?? '');
                if ($pdfPath === '' || ! Storage::disk('public')->exists($pdfPath)) {
                    $searchError = 'PDF документот не е достапен за оваа посета.';
                    $visitRequest = null;
                }
            }
        }

        return view('admin.visit-search', [
            'code' => $code,
            'visitRequest' => $visitRequest,
            'searchError' => $searchError,
        ]);
    }

    public function previewVisitPdf(Request $request)
    {
        $code = trim((string) $request->query('code', ''));
        if ($code === '') {
            abort(404);
        }

        $visitRequest = $this->findVisitByCode($code);
        if (! $visitRequest || ! $visitRequest->confirmation) {
            abort(404);
        }

        $pdfPath = (string) ($visitRequest->confirmation->pdf_url ?? '');
        if ($pdfPath === '' || ! Storage::disk('public')->exists($pdfPath)) {
            abort(404);
        }

        return response()->file(
            Storage::disk('public')->path($pdfPath),
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="potvrda-poseta-' . $visitRequest->confirmation->confirmation_code . '.pdf"',
            ]
        );
    }

    public function downloadVisitPdf(Request $request)
    {
        $code = trim((string) $request->query('code', ''));
        if ($code === '') {
            return redirect()->route('admin.visit-search')->with('visit_search_error', 'Внесете код на посета.');
        }

        $visitRequest = $this->findVisitByCode($code);
        if (! $visitRequest || ! $visitRequest->confirmation) {
            return redirect()->route('admin.visit-search', ['code' => $code])->with('visit_search_error', 'Не е пронајдена посета за внесениот код.');
        }

        $pdfPath = (string) ($visitRequest->confirmation->pdf_url ?? '');
        if ($pdfPath === '' || ! Storage::disk('public')->exists($pdfPath)) {
            return redirect()->route('admin.visit-search', ['code' => $code])->with('visit_search_error', 'PDF документот не е достапен за оваа посета.');
        }

        return Storage::disk('public')->download(
            $pdfPath,
            'potvrda-poseta-' . $visitRequest->confirmation->confirmation_code . '.pdf'
        );
    }

    private function findVisitByCode(string $code): ?VisitRequest
    {
        return VisitRequest::query()
            ->with('confirmation')
            ->whereHas('confirmation', function ($query) use ($code) {
                $query->where('confirmation_code', $code)
                    ->orWhere('confirmation_code', 'like', "%{$code}%");
            })
            ->orderByDesc('id')
            ->first();
    }
}
