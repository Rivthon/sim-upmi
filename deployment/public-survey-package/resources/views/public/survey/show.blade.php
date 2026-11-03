@extends('layouts.public')

@section('title', $survey->judul)

@section('content')
<div class="mx-auto max-w-4xl">
    <section class="glass rounded-[1.75rem] p-6 md:p-8">
        <div class="flex flex-col justify-between gap-5 md:flex-row md:items-start">
            <div>
                <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-teal-700">Survey Publik UPMI</p>
                <h1 class="mt-3 text-3xl font-extrabold text-slate-950 md:text-4xl">{{ $survey->judul }}</h1>
                <p class="mt-3 max-w-2xl leading-7 text-slate-600">{{ $survey->deskripsi }}</p>
            </div>
            @if ($survey->ends_at)
                <div x-data="surveyCountdown(@js($survey->ends_at->toIso8601String()))" class="shrink-0 rounded-2xl bg-slate-950 px-5 py-4 text-white">
                    <p class="text-xs font-bold uppercase text-cyan-200">Sisa Waktu</p>
                    <p class="mt-1 text-lg font-extrabold" x-text="label">Menghitung...</p>
                </div>
            @endif
        </div>
    </section>

    @if (session('warning'))
        <div class="mt-5 rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4 font-semibold text-amber-800">{{ session('warning') }}</div>
    @endif

    @if ($errors->any())
        <div class="mt-5 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">
            <p class="font-extrabold">Mohon lengkapi seluruh jawaban.</p>
            <ul class="mt-2 list-disc pl-5 text-sm">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    @if ($alreadySubmitted)
        <section class="glass mt-6 rounded-[1.5rem] p-8 text-center">
            <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-teal-100 text-teal-700">
                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </span>
            <h2 class="mt-4 text-2xl font-extrabold text-slate-950">Survey sudah diisi</h2>
            <p class="mt-2 text-slate-600">Perangkat ini sudah mengirim jawaban untuk survey tersebut.</p>
        </section>
    @else
        <form method="POST" action="{{ route('survey.public.store', $survey->public_token) }}" class="mt-6 space-y-5">
            @csrf

            <section class="glass rounded-[1.5rem] p-6">
                <h2 class="text-lg font-extrabold text-slate-950">Informasi Responden</h2>
                <p class="mt-1 text-sm text-slate-500">Nama boleh dikosongkan jika ingin memberikan jawaban secara anonim.</p>
                <div class="mt-5 grid gap-4 md:grid-cols-2">
                    <div><label class="mb-2 block text-sm font-bold text-slate-700">Nama (opsional)</label><input name="respondent_name" value="{{ old('respondent_name') }}" class="w-full rounded-2xl border-white/70 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500"></div>
                    <div><label class="mb-2 block text-sm font-bold text-slate-700">Unit / Prodi (opsional)</label><input name="respondent_unit" value="{{ old('respondent_unit') }}" class="w-full rounded-2xl border-white/70 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500"></div>
                </div>
            </section>

            @forelse ($survey->questions as $question)
                <section class="glass rounded-[1.5rem] p-6">
                    <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-teal-700">Pertanyaan {{ $loop->iteration }}</p>
                    <h2 class="mt-2 text-lg font-extrabold text-slate-950">{{ $question->pertanyaan }}</h2>

                    @if ($question->tipe === 'skala')
                        <div class="mt-5 grid grid-cols-5 gap-2">
                            @for ($scale = 1; $scale <= 5; $scale++)
                                <label class="cursor-pointer text-center">
                                    <input type="radio" name="jawaban[{{ $question->id }}]" value="{{ $scale }}" class="peer sr-only" @checked(old('jawaban.'.$question->id) == $scale)>
                                    <span class="flex aspect-square items-center justify-center rounded-xl bg-white/75 text-lg font-extrabold text-slate-700 ring-1 ring-white transition peer-checked:bg-teal-600 peer-checked:text-white">{{ $scale }}</span>
                                </label>
                            @endfor
                        </div>
                        <div class="mt-2 flex justify-between text-xs font-semibold text-slate-500"><span>Sangat tidak puas</span><span>Sangat puas</span></div>
                    @elseif ($question->tipe === 'pilihan')
                        <div class="mt-5 grid gap-3">
                            @foreach (($question->opsi ?? []) as $option)
                                <label class="flex cursor-pointer items-center gap-3 rounded-xl bg-white/70 px-4 py-3 ring-1 ring-white"><input type="radio" name="jawaban[{{ $question->id }}]" value="{{ $option }}" @checked(old('jawaban.'.$question->id) === $option) class="text-teal-600 focus:ring-teal-500"><span class="font-semibold text-slate-700">{{ $option }}</span></label>
                            @endforeach
                        </div>
                    @elseif ($question->tipe === 'ganda')
                        <div class="mt-5 grid gap-3">
                            @foreach (($question->opsi ?? []) as $option)
                                <label class="flex cursor-pointer items-center gap-3 rounded-xl bg-white/70 px-4 py-3 ring-1 ring-white"><input type="checkbox" name="jawaban[{{ $question->id }}][]" value="{{ $option }}" @checked(in_array($option, old('jawaban.'.$question->id, []))) class="rounded text-teal-600 focus:ring-teal-500"><span class="font-semibold text-slate-700">{{ $option }}</span></label>
                            @endforeach
                        </div>
                    @else
                        <textarea name="jawaban[{{ $question->id }}]" rows="4" class="mt-5 w-full rounded-2xl border-white/70 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500" placeholder="Tuliskan jawaban Anda">{{ old('jawaban.'.$question->id) }}</textarea>
                    @endif
                </section>
            @empty
                <section class="glass rounded-[1.5rem] p-8 text-center text-slate-600">Belum ada pertanyaan pada survey ini.</section>
            @endforelse

            @if ($survey->questions->isNotEmpty())
                <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-slate-950 px-6 py-4 text-sm font-extrabold text-white shadow-xl shadow-slate-900/20 transition hover:bg-teal-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Kirim Jawaban
                </button>
            @endif
        </form>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function surveyCountdown(deadline) {
        return {
            label: 'Menghitung...',
            timer: null,
            init() {
                const update = () => {
                    const remaining = new Date(deadline).getTime() - Date.now();
                    if (remaining <= 0) {
                        this.label = 'Waktu berakhir';
                        clearInterval(this.timer);
                        setTimeout(() => window.location.reload(), 1200);
                        return;
                    }
                    const days = Math.floor(remaining / 86400000);
                    const hours = Math.floor((remaining % 86400000) / 3600000);
                    const minutes = Math.floor((remaining % 3600000) / 60000);
                    this.label = `${days} hari ${hours} jam ${minutes} menit`;
                };
                update();
                this.timer = setInterval(update, 30000);
            }
        };
    }
</script>
@endpush
