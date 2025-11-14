<!DOCTYPE html>
<html>
<head>
    <title>ToDo App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #1f1f1f;
            color: #eaeaea;
        }
        .card {
            background-color: #2b2b2b;
            border-radius: 12px;
            border: 1px solid #3a3a3a;
        }
        .table {
            color: #eaeaea;
        }
        .table thead {
            background-color: #3c3c3c;
        }
        .table tbody tr {
            background-color: #2a2a2a;
            border-bottom: 1px solid #444;
        }
        .table tbody tr:hover {
            background-color: #3a3a3a;
        }
        .form-control, .form-check-input {
            background-color: #151515;
            color: #eaeaea;
            border: 1px solid #555;
        }
        .btn-primary {
            background-color: #0d6efd;
            border-radius: 8px;
        }
        .btn-success {
            border-radius: 8px;
        }
        .btn-danger {
            border-radius: 8px;
        }
    </style>
</head>

<body class="p-4">

<div class="container">

    <h2 class="mb-4 text-info fw-bold">📘 Daftar ToDo</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- CARD FORM -->
    <div class="card p-4 mb-4 shadow">
        <h4 class="mb-3">➕ Tambah ToDo</h4>

        <form action="{{ route('store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Judul ToDo</label>
                    <input type="text" name="title" class="form-control" required placeholder="Masukkan judul...">
                </div>

                <div class="col-md-5">
                    <label class="form-label">Keterangan</label>
                    <input type="text" name="description" class="form-control" placeholder="Masukkan keterangan...">
                </div>

                <div class="col-md-1 d-flex align-items-center">
                    <label class="form-check-label">
                        <input type="checkbox" name="is_done" class="form-check-input"> Selesai
                    </label>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100">Tambah</button>
                </div>
            </div>
        </form>
    </div>

    <!-- CARD TABLE -->
    <div class="card p-4 shadow">
        <h4 class="mb-3">📋 Data ToDo</h4>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                    <th>Tanggal Selesai</th>
                    <th style="width: 200px">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($todos as $todo)
                <tr>
                    <td>{{ $todo->title }}</td>
                    <td>{{ $todo->description }}</td>
                    <td>
                        @if($todo->is_done)
                            <span class="badge bg-success">Selesai ✔</span>
                        @else
                            <span class="badge bg-warning text-dark">Belum</span>
                        @endif
                    </td>
                    <td>{{ $todo->completed_at ?? '-' }}</td>
                    <td>
                        @if(!$todo->is_done)
                            <a href="{{ route('complete', $todo->id) }}" 
                               class="btn btn-success btn-sm">Tandai Selesai</a>
                        @endif

                        <form action="{{ route('delete', $todo->id) }}" 
                              method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-3">
                        Belum ada ToDo. Tambahkan tugas baru! ✨
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

</div>

</body>
</html>
