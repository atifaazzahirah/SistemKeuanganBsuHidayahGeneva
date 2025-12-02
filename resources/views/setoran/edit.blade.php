@extends('layouts.app')
@section('title', 'Edit Setoran')

@push('styles')

@endpush

@section('content')
<div class="container py-4">
    <div class="card setoran-card">
        
        <!-- HEADER -->
        <div class="card bg-success text-white text-center py-4">
            <h3 class="mb-0 fs-4 text-header-setoran">FORM EDIT SETORAN</h3>
        </div>

        <div class="card-body p-5">
            <form id="formSetoran" action="{{ route('setoran.update', $group_id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- HEADER FORM -->
                <div class="row g-4 mb-5">
                    <div class="col-md-5">
                        <label class="form-label label-nasabah">Nama Nasabah</label>

                        <select class="form-select form-select-lg" disabled>
                            <option selected>{{ $first->nasabah->Nama }}</option>
                        </select>

                        <input type="hidden" name="Id_nasabah" value="{{ $first->Id_nasabah }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Nomor Induk</label>
                        <input type="text" id="noInduk" 
                               class="form-control form-control-lg text-center bg-light"
                               value="{{ $first->nasabah->No_Induk ?? '' }}" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Tanggal Penimbangan <span class="text-danger">*</span></label>
                        <input type="date" name="Tgl_Penjualan" 
                               class="form-control form-control-lg"
                               value="{{ $first->Tgl_Penjualan->format('Y-m-d') }}" required>
                    </div>
                </div>

                <hr class="my-5 border-2">

                <h5 class="text-center mb-4 title-detail-sampah">DETAIL SAMPAH</h5>

                <div class="row g-4">
                    @php
                        $detail = $detail ?? [];
                        if (empty($detail) && isset($setoran)) {
                            $detail = [];
                            $detail[$setoran->id_jenis] = ['berat' => $setoran->total_berat];
                        }
                        $counter = 0;
                    @endphp

                    @foreach($jenis_sampah as $j)
                        @if($counter % 3 == 0 && $counter > 0)
                            </div><div class="row g-4 mt-3">
                        @endif

                        @php
                            $beratLama = $detail[$j->ID_Jenis]['berat'] ?? 0;
                            $subtotalLama = $beratLama * $j->Harga_kg;
                        @endphp

                        <div class="col-md-4">
                            <div class="jenis-card p-4 shadow-sm h-100">
                                <h6 class="jenis-title mb-3">{{ $j->Jenis_Sampah }}</h6>

                                <div class="row g-3">
                                    <div class="col-6">
                                        <input type="number" step="0.01" min="0"
                                               class="form-control text-center berat-input"
                                               data-harga="{{ $j->Harga_kg }}"
                                               name="berat[{{ $j->ID_Jenis }}]"
                                               value="{{ $beratLama > 0 ? $beratLama : '' }}">
                                    </div>

                                    <div class="col-6">
                                        <input type="text" class="form-control text-end nilai-rp text-harga"
                                               readonly value="{{ $subtotalLama > 0 ? number_format($subtotalLama, 0, ',', '.') : 0 }}">
                                        <small class="text-muted d-block text-end mt-1">
                                            Rp {{ number_format($j->Harga_kg, 0, ',', '.') }} / Kg
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @php $counter++; @endphp
                    @endforeach
                </div>

                <div class="text-end mt-5">
                    <div class="text-end mt-5">
                   <a href="{{ route('setoran.index') }}" id="btnBatal" 
                        class="btn btn-batal btn-lg px-5">
                            Batal
                        </a>
                        <button type="button" id="btnSimpan" 
                                class="btn btn-simpan btn-lg px-5 ms-3">
                            Simpan Setoran
                        </button>
                </div>
            </form>
        </div>
    </div>
</div>

<link rel="stylesheet" href="{{ asset('css/setoran.css') }}">
{{-- SCRIPT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('.berat-input');
    const select = document.getElementById('nasabahSelect');
    const noInduk = document.getElementById('noInduk');
    const form = document.getElementById('formSetoran');
    const btnSimpan = document.getElementById('btnSimpan');
    const btnBatal = document.getElementById('btnBatal');

    select?.addEventListener('change', function () {
        noInduk.value = this.selectedOptions[0]?.dataset.noInduk || '';
    });

    function hitung() {
        inputs.forEach(input => {
            const berat = parseFloat(input.value) || 0;
            const harga = parseFloat(input.dataset.harga) || 0;
            const subtotal = berat * harga;
            const nilaiEl = input.closest('.col-6').nextElementSibling.querySelector('.nilai-rp');
            if (nilaiEl) nilaiEl.value = subtotal > 0 ? subtotal.toLocaleString('id-ID') : '0';
        });
    }
    inputs.forEach(i => i.addEventListener('input', hitung));
    hitung();

    btnBatal.addEventListener('click', function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Batalkan perubahan?',
            text: "Perubahan tidak akan disimpan",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Batal',
            cancelButtonText: 'Lanjut Edit'
        }).then((res) => {
            if (res.isConfirmed) window.location.href = "{{ route('setoran.index') }}";
        });
    });

        btnSimpan.addEventListener('click', function () {

            let adaData = [...inputs].some(i => (parseFloat(i.value) || 0) > 0);
            if (!adaData)
                return Swal.fire('Error', 'Isi minimal 1 jenis sampah!', 'error');

            Swal.fire({
                title: 'Konfirmasi Update',
                html: `<div class="text-start">
                    <p><strong>Nasabah:</strong> {{ $first->nasabah->Nama }}</p>
                    <p><strong>No. Induk:</strong> {{ $first->nasabah->No_Induk }}</p>
                    <p><strong>Tanggal:</strong> ${document.querySelector('input[name="Tgl_Penjualan"]').value}</p>
                </div>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Update!'
            }).then((res) => {
                if (res.isConfirmed) form.submit();
            });
        });
});
</script>
@endsection
