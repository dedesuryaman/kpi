<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int|null $pekerjaan_id
 * @property int|null $sub_pekerjaan_id
 * @property string|null $title
 * @property string|null $description
 * @property int|null $category_id
 * @property string|null $file_path
 * @property string|null $file_url
 * @property string|null $url
 * @property int|null $as_url
 * @property string|null $file_name
 * @property int|null $file_size
 * @property string|null $mime_type
 * @property int|null $version
 * @property int|null $uploaded_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $human_size
 * @property-read mixed $icon_class
 * @property-read mixed $icon_svg
 * @property-read mixed $simple_type
 * @property-read \App\Models\DokumenKategori|null $kategories
 * @property-read \App\Models\SubKegiatan|null $kegiatan
 * @property-read \App\Models\Pekerjaan|null $pekerjaan
 * @property-read \App\Models\Pekerjaan|null $subPekerjaan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dokumen newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dokumen newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dokumen query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dokumen whereAsUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dokumen whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dokumen whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dokumen whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dokumen whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dokumen whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dokumen whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dokumen whereFileUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dokumen whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dokumen whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dokumen wherePekerjaanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dokumen whereSubPekerjaanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dokumen whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dokumen whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dokumen whereUploadedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dokumen whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dokumen whereVersion($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperDokumen {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Dokumen|null $dokumen
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DokumenKategori newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DokumenKategori newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DokumenKategori query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DokumenKategori whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DokumenKategori whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DokumenKategori whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DokumenKategori whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperDokumenKategori {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $pekerjaan_id
 * @property string|null $tipe_masalah
 * @property string|null $judul
 * @property string|null $deskripsi
 * @property string|null $foto_url
 * @property string|null $file_path
 * @property string|null $file_type
 * @property float|null $file_size
 * @property string|null $mime_type
 * @property string|null $waktu_perlaporan
 * @property string|null $ip_address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Pekerjaan|null $pekerjaan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanKendala newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanKendala newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanKendala query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanKendala whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanKendala whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanKendala whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanKendala whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanKendala whereFileType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanKendala whereFotoUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanKendala whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanKendala whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanKendala whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanKendala whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanKendala wherePekerjaanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanKendala whereTipeMasalah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanKendala whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaporanKendala whereWaktuPerlaporan($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperLaporanKendala {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Log newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Log newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Log query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Log whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Log whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Log whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Log whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Log whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperLog {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $project_member_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ProjectMember $projectMember
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberUser query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberUser whereProjectMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberUser whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperMemberUser {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string|null $address
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $logo
 * @property string|null $npwp
 * @property string|null $website
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Project> $projects
 * @property-read int|null $projects_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereNpwp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereWebsite($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperOrganization {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $organization_id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Organization|null $organization
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectMember> $projectMember
 * @property-read int|null $project_member_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Project> $projects
 * @property-read int|null $projects_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationContact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationContact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationContact query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationContact whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationContact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationContact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationContact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationContact whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationContact whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationContact wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationContact whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperOrganizationContact {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $kegiatan_id
 * @property int|null $kd_urusan
 * @property int|null $kd_bidang
 * @property int|null $kd_unit
 * @property int|null $kd_sub
 * @property int|null $kd_urusan90
 * @property int|null $kd_bidang90
 * @property string|null $kd_kegiatan90
 * @property int|null $kd_sub_kegiatan
 * @property int|null $kd_pekerjaan
 * @property string|null $nm_pekerjaan
 * @property string|null $deskripsi
 * @property string|null $status
 * @property string|null $lokasi
 * @property numeric|null $latitude
 * @property numeric|null $longitude
 * @property int|null $radius
 * @property float|null $pagu_anggaran
 * @property int|null $opd_pengawas_id
 * @property string|null $nomor_kontrak
 * @property string|null $tanggal_kontrak
 * @property int|null $kon_pelaksana_id
 * @property int|null $kon_pengawas_id
 * @property string|null $tanggal_mulai
 * @property string|null $tanggal_selesai
 * @property int|null $masa_pelaksanaan
 * @property string|null $jenis_masa_pelaksanaan
 * @property int|null $masa_pemeliharaan
 * @property string|null $jenis_masa_pemeliharaan
 * @property int|null $progress_rencana
 * @property int|null $progress_fisik_real
 * @property int|null $progress
 * @property string|null $status_progress
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Dokumen> $dokumens
 * @property-read int|null $dokumens_count
 * @property-read \App\Models\Organization|null $konPelaksana
 * @property-read \App\Models\Organization|null $konPengawas
 * @property-read \App\Models\User|null $opdPengawas
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PosPengawasan> $posPengawasan
 * @property-read int|null $pos_pengawasan_count
 * @property-read \App\Models\SubKegiatan|null $subKegiatan
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SubPekerjaan> $subPekerjaan
 * @property-read int|null $sub_pekerjaan_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereJenisMasaPelaksanaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereJenisMasaPemeliharaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereKdBidang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereKdBidang90($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereKdKegiatan90($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereKdPekerjaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereKdSub($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereKdSubKegiatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereKdUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereKdUrusan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereKdUrusan90($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereKegiatanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereKonPelaksanaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereKonPengawasId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereLokasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereMasaPelaksanaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereMasaPemeliharaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereNmPekerjaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereNomorKontrak($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereOpdPengawasId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan wherePaguAnggaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereProgress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereProgressFisikReal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereProgressRencana($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereRadius($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereStatusProgress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereTanggalKontrak($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereTanggalMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereTanggalSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerjaan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperPekerjaan {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $pos_pengawasan_id
 * @property int $kegiatan_id
 * @property int $pekerjaan_id
 * @property int|null $sub_pekerjaan_id
 * @property int $opd_pengawas_id
 * @property string|null $alamat
 * @property numeric|null $latitude
 * @property numeric|null $longitude
 * @property int|null $radius
 * @property int|null $accuracy
 * @property int|null $progres_persentase
 * @property string|null $kondisi_lapangan
 * @property string|null $cuaca
 * @property string|null $foto_url
 * @property string|null $foto_lain
 * @property string|null $catatan
 * @property string|null $status
 * @property string $waktu_pengawasan
 * @property string|null $device_id
 * @property string|null $app_version
 * @property string|null $ip_address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PosPengawasan|null $posPengawasan
 * @property-read \App\Models\SubPekerjaan|null $subPekerjaan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengawasanHistories newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengawasanHistories newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengawasanHistories query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengawasanHistories whereAccuracy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengawasanHistories whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengawasanHistories whereAppVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengawasanHistories whereCatatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengawasanHistories whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengawasanHistories whereCuaca($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengawasanHistories whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengawasanHistories whereFotoLain($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengawasanHistories whereFotoUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengawasanHistories whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengawasanHistories whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengawasanHistories whereKegiatanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengawasanHistories whereKondisiLapangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengawasanHistories whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengawasanHistories whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengawasanHistories whereOpdPengawasId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengawasanHistories wherePekerjaanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengawasanHistories wherePosPengawasanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengawasanHistories whereProgresPersentase($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengawasanHistories whereRadius($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengawasanHistories whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengawasanHistories whereSubPekerjaanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengawasanHistories whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengawasanHistories whereWaktuPengawasan($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperPengawasanHistories {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $kegiatan_id
 * @property int $pekerjaan_id
 * @property int $sub_pekerjaan_id
 * @property string|null $nm_pos
 * @property string|null $nm_lokasi
 * @property numeric|null $latitude
 * @property numeric|null $longitude
 * @property string|null $polyline
 * @property string|null $radius
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PengawasanHistories> $histories
 * @property-read int|null $histories_count
 * @property-read \App\Models\Pekerjaan|null $pekerjaan
 * @property-read \App\Models\SubPekerjaan|null $subPekerjaan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PosPengawasan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PosPengawasan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PosPengawasan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PosPengawasan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PosPengawasan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PosPengawasan whereKegiatanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PosPengawasan whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PosPengawasan whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PosPengawasan whereNmLokasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PosPengawasan whereNmPos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PosPengawasan wherePekerjaanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PosPengawasan wherePolyline($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PosPengawasan whereRadius($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PosPengawasan whereSubPekerjaanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PosPengawasan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperPosPengawasan {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $kd_urusan
 * @property int|null $kd_bidang
 * @property int|null $kd_unit
 * @property int|null $kd_sub
 * @property int $user_id
 * @property string|null $kode_proyek
 * @property int|null $category_id
 * @property int|null $type_id
 * @property int|null $kontraktor_id
 * @property string|null $tahun
 * @property string $name
 * @property string|null $deskripsi
 * @property string|null $lokasi
 * @property string|null $desa
 * @property string|null $kecamatan
 * @property float|null $pagu_anggaran
 * @property float|null $anggaran
 * @property string|null $sumber_dana
 * @property string|null $tahun_anggaran
 * @property string|null $tanggal_mulai
 * @property string|null $tanggal_selesai
 * @property int|null $status_id
 * @property int|null $kemajuan
 * @property string|null $tanggal_realisasi
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $area
 * @property int|null $kegiatan_id
 * @property int|null $radius
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectDocument> $documents
 * @property-read int|null $documents_count
 * @property-read \App\Models\ProjectCategory|null $kategori
 * @property-read \App\Models\Organization|null $kontraktor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectMember> $projectMembers
 * @property-read int|null $project_members_count
 * @property-read \App\Models\ProjectStatus|null $status
 * @property-read \App\Models\SubKegiatan|null $subKegiatan
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectSubTask> $tasks
 * @property-read int|null $tasks_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereAnggaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereDesa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereKdBidang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereKdSub($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereKdUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereKdUrusan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereKecamatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereKegiatanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereKemajuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereKodeProyek($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereKontraktorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereLokasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project wherePaguAnggaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereRadius($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereSumberDana($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereTahunAnggaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereTanggalMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereTanggalRealisasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereTanggalSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperProject {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $code
 * @property string|null $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectCategory whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectCategory whereName($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperProjectCategory {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $project_id
 * @property int|null $subtask_id
 * @property int|null $user_id
 * @property string|null $file_path
 * @property string|null $file_type
 * @property string|null $nama_dokumen
 * @property string|null $judul
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Project|null $project
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectDocument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectDocument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectDocument query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectDocument whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectDocument whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectDocument whereFileType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectDocument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectDocument whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectDocument whereNamaDokumen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectDocument whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectDocument whereSubtaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectDocument whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectDocument whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperProjectDocument {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $project_id
 * @property int|null $contact_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\OrganizationContact|null $contact
 * @property-read \App\Models\MemberUser|null $memberUsers
 * @property-read \App\Models\Project|null $project
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Project> $projects
 * @property-read int|null $projects_count
 * @property-read \App\Models\ProjectSubTask|null $tasks
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMember query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMember whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMember whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMember whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperProjectMember {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $name
 * @property string|null $keterangan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectStatus whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectStatus whereName($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperProjectStatus {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $project_id
 * @property string|null $nama_subtask
 * @property string|null $deskripsi
 * @property int|null $durasi
 * @property float|null $anggaran
 * @property float|null $realisasi
 * @property int|null $progress
 * @property int|null $status
 * @property int|null $urutan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Project|null $project
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectSubTask newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectSubTask newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectSubTask query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectSubTask whereAnggaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectSubTask whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectSubTask whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectSubTask whereDurasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectSubTask whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectSubTask whereNamaSubtask($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectSubTask whereProgress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectSubTask whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectSubTask whereRealisasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectSubTask whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectSubTask whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectSubTask whereUrutan($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperProjectSubTask {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $kd_urussan
 * @property int|null $kd_bidang
 * @property string|null $nm_bidang
 * @property int|null $kd_fungsi
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefBidang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefBidang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefBidang query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefBidang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefBidang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefBidang whereKdBidang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefBidang whereKdFungsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefBidang whereKdUrussan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefBidang whereNmBidang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefBidang whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperRefBidang {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $kd_urusan
 * @property int|null $kd_bidang
 * @property int|null $kd_unit
 * @property int|null $kd_sub
 * @property string|null $nm_sub_unit
 * @property string|null $alias
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SubKegiatan> $subKegiatanCountRelation
 * @property-read int|null $sub_kegiatan_count_relation_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SubKegiatan> $subKegiatans
 * @property-read int|null $sub_kegiatans_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefSubUnit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefSubUnit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefSubUnit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefSubUnit whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefSubUnit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefSubUnit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefSubUnit whereKdBidang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefSubUnit whereKdSub($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefSubUnit whereKdUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefSubUnit whereKdUrusan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefSubUnit whereNmSubUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefSubUnit whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperRefSubUnit {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $kd_urusan
 * @property int|null $kd_bidang
 * @property int|null $kd_unit
 * @property string|null $nm_unit
 * @property string|null $kd_unit90
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefUnit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefUnit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefUnit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefUnit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefUnit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefUnit whereKdBidang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefUnit whereKdUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefUnit whereKdUnit90($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefUnit whereKdUrusan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefUnit whereNmUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefUnit whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperRefUnit {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $kd_urusan
 * @property string|null $nm_urusan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefUrusan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefUrusan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefUrusan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefUrusan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefUrusan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefUrusan whereKdUrusan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefUrusan whereNmUrusan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RefUrusan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperRefUrusan {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $tahun
 * @property int $kd_urusan
 * @property int $kd_bidang
 * @property int $kd_unit
 * @property int $kd_sub
 * @property string|null $nm_unit
 * @property string|null $nm_sub_unit
 * @property int|null $kd_urusan90
 * @property int|null $kd_bidang90
 * @property int|null $kd_program90
 * @property string|null $kd_kegiatan90
 * @property int|null $kd_sub_kegiatan
 * @property string|null $nm_program
 * @property string|null $nm_kegiatan
 * @property string|null $nm_sub_kegiatan
 * @property int|null $no_id
 * @property string|null $tolak_ukur
 * @property float|null $target_angka
 * @property float|null $target_uraian
 * @property float|null $pagu_anggaran
 * @property float|null $realisasi
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $last_sync
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Pekerjaan> $subPekerjaans
 * @property-read int|null $sub_pekerjaans_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubKegiatan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubKegiatan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubKegiatan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubKegiatan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubKegiatan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubKegiatan whereKdBidang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubKegiatan whereKdBidang90($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubKegiatan whereKdKegiatan90($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubKegiatan whereKdProgram90($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubKegiatan whereKdSub($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubKegiatan whereKdSubKegiatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubKegiatan whereKdUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubKegiatan whereKdUrusan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubKegiatan whereKdUrusan90($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubKegiatan whereLastSync($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubKegiatan whereNmKegiatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubKegiatan whereNmProgram($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubKegiatan whereNmSubKegiatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubKegiatan whereNmSubUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubKegiatan whereNmUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubKegiatan whereNoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubKegiatan wherePaguAnggaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubKegiatan whereRealisasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubKegiatan whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubKegiatan whereTargetAngka($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubKegiatan whereTargetUraian($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubKegiatan whereTolakUkur($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubKegiatan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperSubKegiatan {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $kd_sub_pekerjaan
 * @property int $pekerjaan_id
 * @property string|null $judul
 * @property string|null $deskripsi
 * @property string|null $tanggal_mulai
 * @property string|null $tanggal_selesai
 * @property int|null $masa_pelaksanaan
 * @property string|null $jenis_masa_pelaksanaan
 * @property string|null $status_progress
 * @property int|null $persentase_progress
 * @property float|null $anggaran
 * @property float|null $realisasi
 * @property int|null $progress
 * @property int|null $status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Pekerjaan|null $pekerjaan
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PosPengawasan> $posPengawasans
 * @property-read int|null $pos_pengawasans_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubPekerjaan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubPekerjaan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubPekerjaan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubPekerjaan whereAnggaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubPekerjaan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubPekerjaan whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubPekerjaan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubPekerjaan whereJenisMasaPelaksanaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubPekerjaan whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubPekerjaan whereKdSubPekerjaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubPekerjaan whereMasaPelaksanaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubPekerjaan wherePekerjaanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubPekerjaan wherePersentaseProgress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubPekerjaan whereProgress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubPekerjaan whereRealisasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubPekerjaan whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubPekerjaan whereStatusProgress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubPekerjaan whereTanggalMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubPekerjaan whereTanggalSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubPekerjaan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperSubPekerjaan {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $username
 * @property string $email
 * @property string|null $phone
 * @property string|null $photo
 * @property string|null $address
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $status
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string|null $avatar
 * @property string|null $device_id
 * @property string|null $fcm_token
 * @property string|null $last_login_at
 * @property string|null $last_login_ip
 * @property int $is_online
 * @property string|null $api_token
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MemberUser> $memberUsers
 * @property-read int|null $member_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectMember> $members
 * @property-read int|null $members_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Pekerjaan> $pekerjaans
 * @property-read int|null $pekerjaans_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectMember> $projectMembers
 * @property-read int|null $project_members_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFcmToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsOnline($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastLoginIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUser {}
}

