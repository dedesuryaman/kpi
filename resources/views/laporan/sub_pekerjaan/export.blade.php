<table>
    <tr>
        <td>Tahun</td>

        <td style="text-aign:left;">{{ $request->tahun ?? 'Semua' }}</td>
    </tr>
    @if($request->status)
    <tr>
        <td>Status</td>

        <td colspan="7">{{ $request->status ?? 'Semua' }}</td>
    </tr>
    @endif
    @if($opdName)
    <tr>
        <td>OPD</td>

        <td colspan="7">{{ $opdName ?? '-' }}</td>
    </tr>
    @endif
</table>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Proyek</th>
            <th width="80">Sub Pekerjaan</th>
            <th width="20">Anggaran</th>
            <th width="20">Mulai</th>
            <th width="20">Selesai</th>
            <th width="20">Progress</th>
            <th width="20">Status</th>
        </tr>
    </thead>

    <tbody>

        @php
        $lastOpd = null;
        $opdIndex = 0;
        @endphp

        @foreach($data as $row)

        @if($lastOpd != $row->subKegiatan?->nm_sub_unit)

        @php
        $opdIndex++;
        $lastOpd = $row->subKegiatan?->nm_sub_unit;
        @endphp

        <tr class="opd">
            <td>{{ $opdIndex }}</td>
            <td colspan="7">
                {{ $lastOpd }}
            </td>
        </tr>

        @endif


        <tr class="pekerjaan">
            <td></td>
            <td colspan="7">
                {{ $row->nm_pekerjaan }}
            </td>
        </tr>

        @php
        $totalAnggaran = 0;
        $totalProgress = 0;
        $jumlah = $row->subPekerjaan->count();
        @endphp

        @foreach($row->subPekerjaan as $sub)

        @php
        $totalAnggaran += $sub->anggaran ?? 0;
        $totalProgress += $sub->persentase_progress ?? 0;
        @endphp

        <tr>
            <td></td>
            <td></td>
            <td>{{ $sub->judul }}</td>

            <td class="text-right">
                Rp {{ number_format($sub->anggaran,0,',','.') }}
            </td>

            <td class="text-center">
                {{ $sub->tanggal_mulai }}
            </td>

            <td class="text-center">
                {{ $sub->tanggal_selesai }}
            </td>

            <td class="text-center">
                {{ $sub->persentase_progress }} %
            </td>

            <td class="text-center">
                {{ strtoupper($sub->status_progress) }}
            </td>
        </tr>

        @endforeach


        <tr class="total">
            <td></td>
            <td></td>
            <td class="text-right">TOTAL</td>

            <td class="text-right">
                Rp {{ number_format($totalAnggaran,0,',','.') }}
            </td>

            <td colspan="2"></td>

            <td class="text-center">
                {{ $jumlah ? number_format($totalProgress/$jumlah,2) : 0 }} %
            </td>

            <td></td>
        </tr>

        @endforeach

    </tbody>
</table>