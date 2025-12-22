@extends('layouts.app')

@section('title', 'Input Setoran Baru')

@section('content')
<div class="container py-4">

    <div class="card setoran-card">

        <div class="card bg-success text-white text-center py-4">
            <h3 class="mb-0 fs-4 text-header-setoran">FORM TAMBAH SETORAN</h3>
        </div>

        <div class="card-body p-5">

            <form id="formSetoran" action="{{ route('setoran.store') }}" method="POST">
                @csrf

                <!-- HEADER -->
                <div class="row g-4 mb-5">
                    <div class="col-md-5">
                        <label class="form-label label-nasabah">Nama Nasabah <span class="text-danger">*</span></label>
                        <select name="Id_nasabah" id="nasabahSelect" class="form-select form-select-lg" required>
                            <option value="">-- Pilih Nasabah --</option>
                            @foreach($nasabah as $n)
                                <option value="{{ $n->ID_Nasabah }}" data-no-induk="{{ $n->No_Induk }}">
                                    {{ $n->Nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Nomor Induk</label>
                        <input type="text" id="noInduk" class="form-control form-control-lg text-center bg-light" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Tanggal Penimbangan <span class="text-danger">*</span></label>
                        <input type="date" name="Tgl_Penjualan" class="form-control form-control-lg"
                               value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>

                <hr class="my-5 border-2">

                <h5 class="text-success text-center mb-4 title-detail-sampah">DETAIL SAMPAH</h5>

                <div class="row g-4">
                    @php $counter = 0; @endphp
                    @foreach($jenis_sampah as $j)
                        @if($counter % 3 == 0 && $counter > 0)
                            </div><div class="row g-4 mt-3">
                        @endif

                        <div class="col-md-4">
                            <div class="jenis-card p-4 h-100">
                                <h6 class="text-success mb-3 jenis-title">{{ $j->Jenis_Sampah }}</h6>

                                <div class="row g-3">
                                    <div class="col-6">
                                        <input type="number" step="0.01" min="0"
                                               class="form-control text-center berat-input"
                                               data-harga="{{ $j->Harga_kg }}"
                                               name="berat[{{ $j->ID_Jenis }}]"
                                               placeholder="0.00">
                                    </div>

                                    <div class="col-6">
                                        <input type="text" class="form-control text-end nilai-rp text-harga" readonly value="0">
                                        <small class="text-muted d-block text-end mt-1">
                                            Rp {{ number_format($j->Harga_kg) }} / Kg
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @php $counter++; @endphp
                    @endforeach
                </div>

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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const inputs = document.querySelectorAll('.berat-input');
    const select = document.getElementById('nasabahSelect');
    const noInduk = document.getElementById('noInduk');
    const form = document.getElementById('formSetoran');
    const btnSimpan = document.getElementById('btnSimpan');
    const btnBatal = document.getElementById('btnBatal');

    // Tampilkan nomor induk otomatis
    select.addEventListener('change', function () {
        noInduk.value = this.selectedOptions[0]?.dataset.noInduk || '';
    });
    inputs.forEach(input => {
        input.addEventListener('keydown', function (e) {
            if (e.key === '-' || e.key === 'e') {
                e.preventDefault();
            }
        });
        input.addEventListener('input', function () {
            if (this.value < 0) {
                this.value = 0;
            }
            hitung(); // tetap hitung otomatis
        });

    });
    function hitung() {
        inputs.forEach(input => {
            const berat = parseFloat(input.value) || 0;
            const harga = parseFloat(input.dataset.harga) || 0;
            const subtotal = berat * harga;

            const nilaiEl = input.closest('.col-6')
                .nextElementSibling.querySelector('.nilai-rp');

            nilaiEl.value = subtotal > 0
                ? subtotal.toLocaleString('id-ID')
                : '0';
        });
    }
    btnBatal.addEventListener('click', function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Yakin Batal?',
            text: "Data yang sudah diisi akan hilang",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Batal',
            cancelButtonText: 'Lanjut Isi'
        }).then((res) => {
            if (res.isConfirmed) {
                window.location.href = "{{ route('setoran.index') }}";
            }
        });
    });
    btnSimpan.addEventListener('click', function () {

        if (!select.value)
            return Swal.fire('Error', 'Pilih nasabah dulu!', 'error');

        let adaData = [...inputs].some(i => (parseFloat(i.value) || 0) > 0);
        if (!adaData)
            return Swal.fire('Error', 'Isi minimal 1 jenis sampah!', 'error');

        Swal.fire({
            title: 'Pastikan Data Benar',
            html: `
                <div class="text-start">
                    <p><strong>Nasabah:</strong> ${select.selectedOptions[0].text}</p>
                    <p><strong>No. Induk:</strong> ${noInduk.value}</p>
                    <p><strong>Tanggal:</strong> ${document.querySelector('input[name="Tgl_Penjualan"]').value}</p>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan!'
        }).then((res) => {
            if (res.isConfirmed) form.submit();
        });

    });

});
</script>

@endsection
