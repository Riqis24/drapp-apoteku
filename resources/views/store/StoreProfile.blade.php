<x-app-layout>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css"> --}}

    <style>
        #main {
            background: #f4f7f6;
            min-height: 100vh;
            padding: 3rem 0;
        }

        .card {
            border: none;
            border-radius: 1.25rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            background: #4361ee !important;
            border-bottom: none;
            padding: 1.5rem;
            border-radius: 1.25rem 1.25rem 0 0 !important;
        }

        .form-label {
            font-weight: 600;
            color: #344767;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }

        .input-group-text {
            background-color: #fff;
            border-right: none;
            color: #adb5bd;
            border-radius: 0.75rem 0 0 0.75rem;
        }

        .form-control {
            border-radius: 0.75rem;
            padding: 0.6rem 1rem;
            border: 1px solid #d2d6da;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 0.75rem 0.75rem 0;
        }

        .form-control:focus {
            border-color: #4361ee;
            box-shadow: 0 0 0 2px rgba(67, 97, 238, 0.2);
        }

        .btn {
            border-radius: 0.75rem;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-success {
            background-color: #2dce89;
            border: none;
        }

        .btn-success:hover {
            background-color: #28b97b;
            transform: translateY(-1px);
        }
    </style>

    <div id="main">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow">
                        <div class="card-header text-center">
                            <h5 class="mb-0 text-white">
                                <i class="bi bi-building-fill-check me-2"></i> Profil Apotek
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('StoreProfile.store') }}" method="POST">
                                @csrf

                                <div class="mb-3 mt-2">
                                    <label for="name" class="form-label">Nama Apotek <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-shop"></i></span>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ old('name', $profile->name ?? '') }}" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="owner" class="form-label">Nama Pemilik</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                            <input type="text" class="form-control" id="owner" name="owner"
                                                value="{{ old('owner', $profile->owner ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="npwp" class="form-label">NPWP</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                            <input type="text" class="form-control" id="npwp" name="npwp"
                                                value="{{ old('npwp', $profile->npwp ?? '') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label">Alamat Lengkap</label>
                                    <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $profile->address ?? '') }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Nomor Telepon</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                            <input type="tel" class="form-control" id="phone" name="phone"
                                                value="{{ old('phone', $profile->phone ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                            <input type="email" class="form-control" id="email" name="email"
                                                value="{{ old('email', $profile->email ?? '') }}">
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="mb-3">
                                    <label for="logo" class="form-label">Path File Logo</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-image"></i></span>
                                        <input type="text" class="form-control" id="logo" name="logo"
                                            value="{{ old('logo', $profile->logo ?? '') }}">
                                    </div>
                                    <small class="text-muted ms-1">Current:
                                        {{ $profile->logo ?? 'Belum ada logo' }}</small>
                                </div> --}}

                                <div class="mb-4">
                                    <label for="footer_note" class="form-label">Catatan Kaki Invoice</label>
                                    <textarea class="form-control" id="footer_note" name="footer_note" rows="3">{{ old('footer_note', $profile->footer_note ?? '') }}</textarea>
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <button type="reset" class="btn btn-light border">Reset</button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-save me-2"></i>
                                        {{ isset($profile) ? 'Perbarui Data' : 'Simpan Data' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
