@extends('admin.layouts.app')
@section('title', 'Пребарај посета')
@section('page-title', 'Пребарај посета')
@section('page-subtitle', 'Внеси код и отвори ја потврдата директно како PDF')

@section('content')
<div class="vs-wrap">

  {{-- Search card --}}
  <div class="vs-card vs-card--search">
    <div class="vs-card-header">
      <div class="vs-icon-box">
        <i class="fas fa-qrcode"></i>
      </div>
      <div>
        <h2 class="vs-card-title">Код на посета</h2>
        <p class="vs-card-sub">Внеси го кодот — PDF-от се отвора автоматски</p>
      </div>
    </div>

    <form id="visit-search-form" action="{{ route('admin.visit-search') }}" method="GET">
      <label class="vs-label" for="visit-code">Код на посета</label>
      <div class="vs-form-row">
        <input
          id="visit-code" name="code" type="text"
          value="{{ old('code', $code ?? '') }}"
          placeholder="пр. VIS-2024-00142"
          autocomplete="off"
          class="vs-input"
        >
        <button type="submit" class="vs-btn-search">
          <i class="fas fa-search"></i>
          <span>Пребарај</span>
        </button>
      </div>

      <div class="vs-hint">
        <span class="vs-hint-dot"></span>
        <span class="vs-hint-text">Автоматски пребарува по <strong>0.5s</strong> од внесувањето</span>
      </div>

      @if(session('visit_search_error') || ($searchError ?? null))
        <div class="vs-error">
          <i class="fas fa-exclamation-circle"></i>
          {{ session('visit_search_error') ?? $searchError }}
        </div>
      @endif
    </form>
  </div>

  {{-- Result card --}}
  @if(($visitRequest ?? null) && !($searchError ?? null))
    @php
      $statusLabels = [
        'approved' => 'Одобрено',
        'cancelled_by_visitor' => 'Откажано од посетител',
        'cancelled_by_admin' => 'Откажано од админ',
        'completed' => 'Завршено',
        'no_show' => 'Не се појавил',
      ];
      $currentStatus = $visitRequest->status ?? null;
      $badgeClass = 'vs-status-badge';
      if ($currentStatus === 'cancelled_by_admin') {
        $badgeClass .= ' vs-status-badge--danger';
      }
    @endphp
    <div class="vs-card">
      <div class="vs-result-header">
        <div class="vs-result-meta">
          <span class="vs-code-pill">
            <i class="fas fa-file-alt"></i>
            {{ $visitRequest->confirmation->confirmation_code ?? '—' }}
          </span>
          <span class="{{ $badgeClass }}">
            <i class="fas fa-check"></i>
            {{ $statusLabels[$visitRequest->status] ?? ($visitRequest->status ?? '—') }}
          </span>
        </div>
        <div class="vs-result-actions">
          <a href="{{ route('admin.visit-search.download', ['code' => $code]) }}" class="vs-btn vs-btn--secondary">
            <i class="fas fa-download"></i>
            Симни PDF
          </a>
          <a href="{{ route('admin.visit-search.preview', ['code' => $code]) }}" target="_blank" class="vs-btn vs-btn--primary">
            <i class="fas fa-external-link-alt"></i>
            Отвори
          </a>
        </div>
      </div>

      <div class="vs-pdf-wrapper">
        <iframe
          src="{{ route('admin.visit-search.preview', ['code' => $code]) }}"
          class="vs-pdf-frame"
          title="PDF преглед"
        ></iframe>
      </div>
    </div>
  @endif

</div>

<style>
.vs-wrap { max-width: 860px; margin: 0 auto; padding: 18px; display: flex; flex-direction: column; gap: 16px; }

.vs-card {
  width: 100%;
  box-sizing: border-box;
  background: #fff;
  border: 1px solid #e8ecf0;
  border-radius: 14px;
  padding: 22px 24px;
  box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 4px 12px rgba(0,0,0,.05);
}

.vs-card-header { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 18px; }
.vs-icon-box {
  width: 38px; height: 38px; flex-shrink: 0;
  background: #dbeafe; color: #2563eb;
  border-radius: 9px; display: flex; align-items: center; justify-content: center;
  font-size: 15px;
}
.vs-card-title { font-size: 15px; font-weight: 700; color: #1e293b; margin: 0; }
.vs-card-sub   { font-size: 13px; color: #64748b; margin: 2px 0 0; }

.vs-label { font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 6px; display: block; }
.vs-form-row { display: flex; gap: 8px; }
.vs-input {
  flex: 1; height: 42px; padding: 0 14px;
  font-size: 14px; color: #1e293b;
  border: 1px solid #cbd5e1; border-radius: 9px;
  background: #f8fafc; outline: none; transition: border-color .15s, box-shadow .15s;
}
.vs-input:focus { border-color: #2f5fa8; box-shadow: 0 0 0 3px rgba(47,95,168,.12); background: #fff; }
.vs-btn-search {
  height: 42px; padding: 0 18px; flex-shrink: 0;
  display: inline-flex; align-items: center; gap: 7px;
  font-size: 13px; font-weight: 600; color: #fff;
  background: #2f5fa8; border: none; border-radius: 9px;
  cursor: pointer; transition: background .12s;
}
.vs-btn-search:hover { background: #244f90; }

.vs-hint { display: flex; align-items: center; gap: 7px; margin-top: 10px; }
.vs-hint-dot { width: 6px; height: 6px; border-radius: 50%; background: #22c55e; flex-shrink: 0; }
.vs-hint-text { font-size: 12px; color: #94a3b8; }
.vs-hint-text strong { color: #64748b; font-weight: 600; }

.vs-error {
  display: flex; align-items: center; gap: 8px;
  margin-top: 12px; padding: 10px 14px;
  background: #fef2f2; border: 1px solid #fecaca;
  border-radius: 8px; font-size: 13px; color: #dc2626;
}

.vs-result-header {
  display: flex; align-items: center; justify-content: space-between;
  gap: 12px; margin-bottom: 16px; flex-wrap: wrap;
}
.vs-result-meta { display: flex; align-items: center; gap: 8px; }
.vs-code-pill {
  display: inline-flex; align-items: center; gap: 6px;
  background: #f1f5f9; border: 1px solid #e2e8f0;
  border-radius: 8px; padding: 5px 12px;
  font-size: 13px; font-weight: 600; color: #1e293b;
}
.vs-code-pill i { color: #64748b; font-size: 13px; }
.vs-status-badge {
  display: inline-flex; align-items: center; gap: 5px;
  background: #dcfce7; border-radius: 8px;
  padding: 4px 10px; font-size: 12px; font-weight: 600; color: #15803d;
}
.vs-status-badge--danger {
  background: #fee2e2; color: #b91c1c;
}
.vs-status-badge--danger i { color: #b91c1c; }
.vs-result-actions { display: flex; gap: 8px; }
.vs-btn {
  height: 36px; padding: 0 14px;
  display: inline-flex; align-items: center; gap: 6px;
  font-size: 13px; font-weight: 600; border-radius: 8px;
  cursor: pointer; text-decoration: none; transition: background .12s;
}
.vs-btn--secondary {
  background: #fff; color: #334155;
  border: 1px solid #cbd5e1;
}
.vs-btn--secondary:hover { background: #f8fafc; }
.vs-btn--primary { background: #2f5fa8; color: #fff; border: none; }
.vs-btn--primary:hover { background: #244f90; }

.vs-pdf-wrapper {
  background: #f8fafc;
  border: 1px solid #e8ecf0;
  border-radius: 10px; padding: 12px;
}
.vs-pdf-frame { width: 100%; height: 72vh; border: none; border-radius: 6px; display: block; }
</style>

<script>
(function () {
  const input = document.getElementById('visit-code');
  const form  = document.getElementById('visit-search-form');
  if (!input || !form) return;
  let t = null;
  input.addEventListener('input', function () {
    clearTimeout(t);
    if (input.value.trim().length < 2) return;
    t = setTimeout(() => form.submit(), 550);
  });
})();
</script>
@endsection