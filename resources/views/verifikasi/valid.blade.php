<h2 style="color:green;">✔ DOKUMEN VALID</h2>

Nomor Dokumen : {{ $doc->nomor_dokumen }} <br>
Jenis Laporan : {{ $doc->jenis_laporan }} <br>
Tahun : {{ $doc->tahun }} <br>
Tanggal Terbit : {{ $doc->created_at->format('d F Y H:i') }} <br>

<hr>
Kode Keamanan:
{{ $doc->hash }}