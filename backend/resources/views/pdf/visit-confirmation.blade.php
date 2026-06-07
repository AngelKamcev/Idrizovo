<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111827;
            margin: 0;
            padding: 28px;
        }
        .header {
            border-bottom: 2px solid #0f1c2e;
            padding-bottom: 14px;
            margin-bottom: 20px;
        }
        .title {
            font-size: 22px;
            font-weight: bold;
            margin: 0 0 6px 0;
        }
        .subtitle {
            margin: 0;
            color: #4b5563;
        }
        .code-box {
            border: 2px solid #0f1c2e;
            border-radius: 10px;
            padding: 16px;
            text-align: center;
            margin: 18px 0 22px;
            background: #f8fafc;
        }
        .code {
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 4px;
            margin-top: 6px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 8px 0;
            vertical-align: top;
        }
        .label {
            width: 35%;
            color: #6b7280;
        }
        .footer {
            margin-top: 24px;
            font-size: 11px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    @php
        $statusLabels = [
            'approved' => 'Одобрено',
            'cancelled_by_visitor' => 'Откажано од посетител',
            'cancelled_by_admin' => 'Откажано од админ',
            'completed' => 'Завршено',
            'no_show' => 'Не се појавил',
        ];
    @endphp
    <div class="header">
        <p class="title">Потврда за закажана посета</p>
        <p class="subtitle">КПУ Идризово</p>
    </div>

    <div class="code-box">
        <div>Ваш код за посета</div>
        <div class="code">{{ $confirmation->confirmation_code }}</div>
    </div>

    <table>
        <tr>
            <td class="label">Посетител</td>
            <td>{{ $visitRequest->visitor_first_name }} {{ $visitRequest->visitor_last_name }}</td>
        </tr>
        <tr>
            <td class="label">Број на осудено лице</td>
            <td>{{ $visitRequest->requested_inmate_number }}</td>
        </tr>
        <tr>
            <td class="label">Датум</td>
            <td>{{ $visitRequest->visit_date?->format('d.m.Y') }}</td>
        </tr>
        <tr>
            <td class="label">Термин</td>
            <td>{{ $visitRequest->visitSchedule?->group_name ?? '—' }} / {{ $visitRequest->timeSlot ? $visitRequest->timeSlot->start_time . ' - ' . $visitRequest->timeSlot->end_time : '—' }}</td>
        </tr>
        <tr>
            <td class="label">Статус</td>
            <td>{{ $statusLabels[$visitRequest->status] ?? $visitRequest->status }}</td>
        </tr>
        <tr>
            <td class="label">Издадено</td>
            <td>{{ $confirmation->issued_at?->format('d.m.Y H:i') }}</td>
        </tr>
    </table>

    @if($visitRequest->companions->isNotEmpty())
        <div class="footer">
            Придружници: {{ $visitRequest->companions->map(fn ($c) => trim($c->first_name . ' ' . $c->last_name))->implode(', ') }}
        </div>
    @endif

    <div class="footer">
        Оваа потврда е генерирана автоматски. Чувајте го кодот и PDF документот при влез.
    </div>
</body>
</html>