@extends('layouts.app')

@section('title', 'Закажи Посета - Идризово')

@section('content')

<!-- Содржина ќе биде додадена подоцна -->
<!doctype html>
<html lang="mk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Закажи посета</title>
  <style>
    .drop-menu { display: none; }
    .drop-menu.open { display: block; }
    .arrow-icon { transition: transform .25s; }
    .arrow-icon.rotated { transform: rotate(180deg); }
    .cal-day { transition: background .12s, color .12s; }
    .field-input:focus, .drop-btn:focus, .textarea:focus {
      border-color: rgba(47,95,168,0.7) !important;
      box-shadow: 0 0 0 3px rgba(47,95,168,0.15);
    }
    .field-error { border-color: rgba(220,60,60,0.6) !important; }
  </style>
</head>
<body>

<section id="zakazi-poseta"
  class="w-full px-5 md:px-20 py-20 md:py-32"
  style="background: linear-gradient(to bottom, #ffffff 0%, #dbe6f5 12%, #9fb7dc 25%, #6f8fc2 38%, #6f8fc2 65%, #dbe6f5 88%, #ffffff 100%)">

  <div class="max-w-[680px] mx-auto">

    {{-- HEADER --}}
    <div class="text-center mb-12">
      <h2 class="text-[30px] md:text-[36px] font-medium text-[#3d5f96] tracking-tight mb-3">
        Закажи посета
      </h2>
      <p class="max-w-[520px] mx-auto text-[14px] text-[#4a6b9a] leading-7">
        Пополнете ги потребните податоци за закажување посета.
        По успешно закажување ќе добиете потврда која треба да ја покажете при влез.
      </p>
    </div>

    @if(session('success'))
      <div class="mb-8 rounded-[18px] border border-emerald-200 bg-emerald-50 px-5 py-4 text-[14px] text-emerald-800">
        {{ session('success') }}
      </div>
    @endif

    {{-- ФОРМА --}}
    <form id="visitForm"
      method="POST"
      action="{{ route('zakazi-poseta.submit') }}"
      class="rounded-[24px] p-7 md:p-10"
      style="background: rgba(255,255,255,0.22); border: 1px solid rgba(255,255,255,0.45); backdrop-filter: blur(12px);">

      @csrf

      <div class="flex flex-col gap-5">

        {{-- ИМЕ / ПРЕЗИМЕ --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-[12px] font-medium text-white/90 mb-1.5 tracking-wide">Ime</label>
            <input id="firstName" name="visitor_first_name" type="text" placeholder="Внесете име"
              class="field-input w-full h-[50px] rounded-[14px] px-4 text-[14px] text-[#0b1a2b] outline-none"
              style="background: rgba(255,255,255,0.88); border: 1px solid rgba(255,255,255,0.55);">
          </div>
          <div>
            <label class="block text-[12px] font-medium text-white/90 mb-1.5 tracking-wide">Презиме</label>
            <input id="lastName" name="visitor_last_name" type="text" placeholder="Внесете презиме"
              class="field-input w-full h-[50px] rounded-[14px] px-4 text-[14px] text-[#0b1a2b] outline-none"
              style="background: rgba(255,255,255,0.88); border: 1px solid rgba(255,255,255,0.55);">
          </div>
        </div>

        {{-- ОДНОС --}}
        <div>
          <label class="block text-[12px] font-medium text-white/90 mb-1.5 tracking-wide">Однос со осуденото лице</label>
          <div class="relative">
            <button type="button" id="relationDropdownBtn"
              class="drop-btn w-full h-[50px] rounded-[14px] px-4 text-[14px] outline-none flex items-center justify-between"
              style="background: rgba(255,255,255,0.88); border: 1px solid rgba(255,255,255,0.55);"
              aria-haspopup="listbox" aria-expanded="false">
              <span id="relationSelected" class="text-[#7a8fa8]">Изберете однос</span>
              <svg class="arrow-icon w-4 h-4 text-[#5575ae]" id="relationArrow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"/>
              </svg>
            </button>
            <input type="hidden" id="relationValue" name="visitor_relation_type">
            <div id="relationDropdownMenu"
              class="drop-menu absolute z-30 mt-1.5 w-full rounded-[16px] bg-white overflow-hidden"
              style="border: 1px solid #dbe6f5; box-shadow: 0 8px 24px rgba(0,0,0,0.10);" role="listbox">
              <button type="button" data-value="family" class="relation-option w-full text-left px-4 py-3.5 text-[14px] text-[#0b1a2b] hover:bg-[#eef4fb] transition">Семејство</button>
              <button type="button" data-value="friend" class="relation-option w-full text-left px-4 py-3.5 text-[14px] text-[#0b1a2b] hover:bg-[#eef4fb] transition">Пријател</button>
              <button type="button" data-value="other"  class="relation-option w-full text-left px-4 py-3.5 text-[14px] text-[#0b1a2b] hover:bg-[#eef4fb] transition">Друго</button>
            </div>
          </div>
        </div>

        {{-- БРОЈ --}}
        <div>
          <label class="block text-[12px] font-medium text-white/90 mb-1.5 tracking-wide">Број на осудено лице</label>
          <input id="inmateNumber" name="requested_inmate_number" type="text" placeholder="Внесете број"
            class="field-input w-full h-[50px] rounded-[14px] px-4 text-[14px] text-[#0b1a2b] outline-none"
            style="background: rgba(255,255,255,0.88); border: 1px solid rgba(255,255,255,0.55);">
        </div>

        {{-- КАЛЕНДАР --}}
        <div>
          <label class="block text-[12px] font-medium text-white/90 mb-1.5 tracking-wide">Датум на посета</label>
          <input type="hidden" id="visitDate" name="visit_date">
          <div id="calendarBox" class="rounded-[18px] p-5" style="background: rgba(255,255,255,0.95); border: 1px solid rgba(255,255,255,0.5);">
            <div class="flex items-center justify-between mb-4">
              <button type="button" id="prevMonth"
                class="text-[#0b1a2b] text-[24px] leading-none px-2 py-1 rounded-lg hover:bg-[#6f8fc2]/15 transition disabled:opacity-30 disabled:cursor-default">‹</button>
              <h3 id="calendarTitle" class="text-[16px] font-medium text-[#0b1a2b]"></h3>
              <button type="button" id="nextMonth"
                class="text-[#0b1a2b] text-[24px] leading-none px-2 py-1 rounded-lg hover:bg-[#6f8fc2]/15 transition">›</button>
            </div>
            <div class="grid grid-cols-7 text-center mb-2">
              @foreach(['Нед','Пон','Вто','Сре','Чет','Пет','Саб'] as $d)
                <div class="text-[11px] font-medium text-[#6b7fa0] py-1">{{ $d }}</div>
              @endforeach
            </div>
            <div id="calendarDays" class="grid grid-cols-7 gap-1 text-center"></div>
            <div class="mt-3">
              <button type="button" id="clearDate" class="text-[#2f5fa8] text-[13px] font-medium hover:underline">Исчисти</button>
            </div>
          </div>
        </div>

        {{-- ТЕРМИН --}}
        <div>
          <label class="block text-[12px] font-medium text-white/90 mb-1.5 tracking-wide">Одберете време</label>
          <div class="relative">
            <button type="button" id="timeSlotDropdownBtn"
              class="drop-btn w-full h-[50px] rounded-[14px] px-4 text-[14px] outline-none flex items-center justify-between"
              style="background: rgba(255,255,255,0.88); border: 1px solid rgba(255,255,255,0.55);"
              aria-haspopup="listbox" aria-expanded="false">
              <span id="timeSlotSelected" class="text-[#7a8fa8]">Изберете термин</span>
              <svg class="arrow-icon w-4 h-4 text-[#5575ae]" id="timeSlotArrow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"/>
              </svg>
            </button>
            <input type="hidden" id="timeSlotValue" name="visit_schedule_id">
            <div id="timeSlotDropdownMenu"
              class="drop-menu absolute z-30 mt-1.5 w-full rounded-[16px] bg-white overflow-hidden"
              style="border: 1px solid #dbe6f5; box-shadow: 0 8px 24px rgba(0,0,0,0.10);" role="listbox">
              @forelse(($visitSchedules ?? []) as $schedule)
                <button type="button" data-value="{{ $schedule->id }}" data-label="{{ $schedule->group_name }} | {{ $schedule->days_label }} | {{ $schedule->time_range }}" class="time-slot-option w-full text-left px-4 py-3.5 text-[14px] text-[#0b1a2b] hover:bg-[#eef4fb] transition">
                  {{ $schedule->group_name }} · {{ $schedule->days_label }} · {{ $schedule->time_range }}
                </button>
              @empty
                <button type="button" data-value="" class="time-slot-option w-full text-left px-4 py-3.5 text-[14px] text-[#0b1a2b] hover:bg-[#eef4fb] transition">Нема термини</button>
              @endforelse
            </div>
          </div>
        </div>

        {{-- ПРИДРУЖНИЦИ --}}
        <div>
          <label class="block text-[12px] font-medium text-white/90 mb-1.5 tracking-wide">Лица кои доаѓаат со вас</label>
          <textarea id="companions" name="companions" rows="4" placeholder="Внесете ime и презиме за секое лице кое доаѓа со вас..."
            class="textarea w-full rounded-[14px] px-4 py-3.5 text-[14px] text-[#0b1a2b] outline-none resize-none"
            style="background: rgba(255,255,255,0.88); border: 1px solid rgba(255,255,255,0.55);"></textarea>
        </div>

      </div>

      {{-- ИНФО --}}
      <div class="mt-5 rounded-[16px] px-5 py-4" style="background: rgba(255,255,255,0.14); border: 1px solid rgba(255,255,255,0.22);">
        <p class="text-[13px] text-white/85 leading-7">
          Посетата трае 2 часа. Откажување е можно најдоцна 48 часа пред закажаниот термин.
          По испраќање на барањето, терминот автоматски се одобрува доколку има слободни места.
        </p>
      </div>

      {{-- ПОТВРДА --}}
      <label class="flex items-start gap-3 mt-5 cursor-pointer">
        <input id="confirmCheck" name="confirm_check" value="1" type="checkbox" class="mt-0.5 w-4 h-4 rounded accent-[#2f5fa8] flex-shrink-0">
        <span class="text-[13px] text-white/90 leading-6">Потврдувам дека внесените податоци се точни.</span>
      </label>

      {{-- ERROR --}}
      <div id="formErrorBox" class="hidden mt-4 rounded-[14px] px-5 py-4 text-center text-[13px] font-medium text-red-800"
        style="background: #fee2e2; border: 1px solid #fca5a5;"></div>

      {{-- SUBMIT --}}
      <div class="flex justify-center mt-8">
        <button type="submit"
          class="bg-[#081529] text-white text-[14px] font-medium px-14 py-3.5 rounded-[14px] hover:bg-[#142944] transition-all hover:-translate-y-0.5 active:translate-y-0">
          Закажи посета
        </button>
      </div>

    </form>
  </div>
</section>

<script>
  /* ── DROPDOWN HELPER ── */
  function initDropdown(btnId, menuId, labelId, arrowId, inputId) {
    const btn = document.getElementById(btnId);
    const menu = document.getElementById(menuId);
    const label = document.getElementById(labelId);
    const arrow = document.getElementById(arrowId);
    const input = document.getElementById(inputId);

    btn.addEventListener('click', e => {
      e.stopPropagation();
      const open = menu.classList.toggle('open');
      arrow.classList.toggle('rotated', open);
      btn.setAttribute('aria-expanded', open);
    });

    menu.querySelectorAll('button').forEach(opt => {
      opt.addEventListener('click', () => {
        label.textContent = opt.textContent.trim();
        label.style.color = '#0b1a2b';
        input.value = opt.dataset.value;
        menu.querySelectorAll('button').forEach(o => o.classList.remove('bg-[#dbe6f5]', 'font-medium'));
        opt.classList.add('bg-[#dbe6f5]', 'font-medium');
        menu.classList.remove('open');
        arrow.classList.remove('rotated');
        btn.setAttribute('aria-expanded', false);
      });
    });
  }

  initDropdown('relationDropdownBtn', 'relationDropdownMenu', 'relationSelected', 'relationArrow', 'relationValue');
  initDropdown('timeSlotDropdownBtn', 'timeSlotDropdownMenu', 'timeSlotSelected', 'timeSlotArrow', 'timeSlotValue');

  @php
    $initialBooking = request()->only([
        'visitor_relation_type',
        'visit_date',
        'time_slot_id',
        'companions',
    ]);
  @endphp

  const initialBooking = @json($initialBooking);

  if (initialBooking.visitor_relation_type) {
    const relationOption = document.querySelector(`#relationDropdownMenu button[data-value="${initialBooking.visitor_relation_type}"]`);
    if (relationOption) {
      document.getElementById('relationSelected').textContent = relationOption.textContent.trim();
      document.getElementById('relationSelected').style.color = '#0b1a2b';
      document.getElementById('relationValue').value = initialBooking.visitor_relation_type;
    }
  }

  if (initialBooking.visit_date) {
    document.getElementById('visitDate').value = initialBooking.visit_date;
  }

  if (initialBooking.time_slot_id) {
    const timeOption = document.querySelector(`#timeSlotDropdownMenu button[data-value="${initialBooking.time_slot_id}"]`);
    if (timeOption) {
      document.getElementById('timeSlotSelected').textContent = timeOption.textContent.trim();
      document.getElementById('timeSlotSelected').style.color = '#0b1a2b';
      document.getElementById('timeSlotValue').value = initialBooking.time_slot_id;
    }
  }

  if (initialBooking.companions) {
    document.getElementById('companions').value = initialBooking.companions;
  }

  document.addEventListener('click', () => {
    ['relationDropdownMenu','timeSlotDropdownMenu'].forEach(id => document.getElementById(id).classList.remove('open'));
    ['relationArrow','timeSlotArrow'].forEach(id => document.getElementById(id).classList.remove('rotated'));
    ['relationDropdownBtn','timeSlotDropdownBtn'].forEach(id => document.getElementById(id).setAttribute('aria-expanded', false));
  });

  /* ── CALENDAR ── */
  const monthsMk = ['Јануари','Февруари','Март','Април','Мај','Јуни','Јули','Август','Септември','Октомври','Ноември','Декември'];
  const today = new Date(); today.setHours(0,0,0,0);
  let cur = new Date(today.getFullYear(), today.getMonth(), 1);
  let selectedDate = null;

  function renderCalendar() {
    const y = cur.getFullYear(), m = cur.getMonth();
    document.getElementById('calendarTitle').textContent = monthsMk[m] + ' ' + y;

    const isMin = y === today.getFullYear() && m === today.getMonth();
    const prev = document.getElementById('prevMonth');
    prev.disabled = isMin;

    const firstDay = new Date(y, m, 1).getDay();
    const lastDate = new Date(y, m + 1, 0).getDate();
    const prevLast = new Date(y, m, 0).getDate();

    let html = '';
    for (let i = firstDay; i > 0; i--) {
      html += `<button type="button" disabled class="h-9 rounded-[10px] text-[13px] text-gray-300">${prevLast - i + 1}</button>`;
    }
    for (let d = 1; d <= lastDate; d++) {
      const dt = new Date(y, m, d);
      const full = `${y}-${String(m+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
      const past = dt < today;
      const sel = selectedDate === full;
      html += `<button type="button" data-date="${full}" ${past ? 'disabled' : ''}
        class="cal-day h-9 rounded-[10px] text-[13px] font-medium
          ${past ? 'text-gray-300 cursor-default' : 'text-[#0b1a2b] hover:bg-[#6f8fc2] hover:text-white cursor-pointer'}
          ${sel ? '!bg-[#2f5fa8] !text-white' : ''}
        ">${d}</button>`;
    }
    document.getElementById('calendarDays').innerHTML = html;

    document.querySelectorAll('.cal-day:not(:disabled)').forEach(btn => {
      btn.addEventListener('click', () => {
        selectedDate = btn.dataset.date;
        document.getElementById('visitDate').value = selectedDate;
        renderCalendar();
      });
    });
  }

  document.getElementById('prevMonth').addEventListener('click', () => { cur.setMonth(cur.getMonth() - 1); renderCalendar(); });
  document.getElementById('nextMonth').addEventListener('click', () => { cur.setMonth(cur.getMonth() + 1); renderCalendar(); });
  document.getElementById('clearDate').addEventListener('click', () => { selectedDate = null; document.getElementById('visitDate').value = ''; renderCalendar(); });

  renderCalendar();

  /* ── VALIDATION ── */
  document.getElementById('visitForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const errBox = document.getElementById('formErrorBox');
    const errors = [];

    if (!document.getElementById('firstName').value.trim()) errors.push('Внесете ime.');
    if (!document.getElementById('lastName').value.trim())  errors.push('Внесете презиме.');
    if (!document.getElementById('relationValue').value)    errors.push('Изберете однос.');
    if (!document.getElementById('inmateNumber').value.trim()) errors.push('Внесете број на осудено лице.');
    if (!document.getElementById('visitDate').value)        errors.push('Изберете датум на посета.');
    if (!document.getElementById('timeSlotValue').value)    errors.push('Изберете термин.');
    if (!document.getElementById('confirmCheck').checked)   errors.push('Потврдете ги податоците.');

    if (errors.length) {
      errBox.textContent = errors[0];
      errBox.classList.remove('hidden');
      errBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
    } else {
      errBox.classList.add('hidden');
      this.submit();
    }
  });
</script>
</body>
</html>

@endsection
