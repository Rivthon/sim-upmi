<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hasil Survei - {{ $survey->judul }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        h2 { margin-bottom: 10px; }
        .chart { margin-bottom: 20px; }
    </style>
</head>
<body>
    <h2>Hasil Survei: {{ $survey->judul }}</h2>
    <p>{{ $survey->deskripsi }}</p>

    @foreach ($survey->questions as $index => $q)
        <strong>{{ $loop->iteration }}. {{ $q->pertanyaan }}</strong> ({{ ucfirst($q->tipe) }})
        <br><br>

        @if (in_array($q->tipe, ['pilihan', 'ganda']) && !empty($q->result_counts))
            <table>
                <thead>
                    <tr>
                        <th>Jawaban</th>
                        <th>Jumlah</th>
                        <th>Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = array_sum($q->result_counts);
                    @endphp
                    @foreach ($q->result_counts as $jawaban => $jumlah)
                        <tr>
                            <td>{{ $jawaban }}</td>
                            <td>{{ $jumlah }}</td>
                            <td>{{ $total > 0 ? round(($jumlah / $total) * 100, 2) . '%' : '0%' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if (!empty($q->chartImage))
                <div class="chart">
                    <img src="{{ $q->chartImage }}" style="max-width: 100%;">
                </div>
            @endif
        @else
            <table>
                <thead>
                    <tr>
                        <th>Jawaban</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($q->responses as $res)
                        <tr>
                            <td>
                                @if ($q->tipe == 'ganda')
                                    @php
                                        $jawaban = implode(', ', json_decode($res->jawaban, true) ?? []);
                                    @endphp
                                    {{ $jawaban }}
                                @else
                                    {{ $res->jawaban }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <hr style="margin: 20px 0;">
    @endforeach
</body>
</html>
