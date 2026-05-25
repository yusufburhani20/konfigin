@extends('admin.layout')

@section('title', 'Manajemen Pengguna')
@section('page_title', 'Manajemen Pengguna')
@section('page_subtitle', 'Kelola akun admin, editor, dan author')

@section('content')
<div class="card">
  <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
    <h2 class="card-title">Daftar Pengguna</h2>
    <button class="btn btn-primary btn-sm" onclick="openFormModal()">
      <i class="fas fa-user-plus"></i> Tambah Pengguna
    </button>
  </div>
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Username</th>
          <th>Peran (Role)</th>
          <th width="150">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($data as $row)
        <tr>
          <td><strong>{{ $row->nama }}</strong></td>
          <td>{{ $row->username }}</td>
          <td>
            @if($row->role === 'admin')
              <span class="badge badge-primary">Admin</span>
            @elseif($row->role === 'editor')
              <span class="badge badge-success">Editor</span>
            @else
              <span class="badge" style="background:var(--border);color:var(--text-primary)">Author</span>
            @endif
          </td>
          <td>
            <div style="display:flex; gap:0.5rem">
              <button class="btn btn-secondary btn-sm" onclick='editData(@json($row))' title="Edit">
                <i class="fas fa-edit"></i>
              </button>
              @if($row->id !== 1 && $row->id !== auth()->id())
              <form method="POST" action="{{ route('admin.users.destroy', $row->id) }}" onsubmit="return confirm('Yakin ingin menghapus akun ini?');" style="margin:0">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
              @endif
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="4" style="text-align:center; padding:2rem">Belum ada data pengguna tambahan.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Add/Edit -->
<div class="modal-overlay" id="modal-form">
  <div class="modal">
    <div class="modal-header">
      <h3 class="modal-title" id="modal-title">Tambah / Edit Pengguna</h3>
      <button type="button" class="modal-close" onclick="closeModal('modal-form')"><i class="fas fa-times"></i></button>
    </div>
    <div class="modal-body">
      <form id="form-data" method="POST" action="">
        @csrf
        <input type="hidden" name="_method" id="form-method" value="POST">
        
        <div class="form-group">
          <label class="form-label" for="nama">Nama Lengkap</label>
          <input type="text" id="nama" name="nama" class="form-input" required>
        </div>
        
        <div class="form-group">
          <label class="form-label" for="username">Username</label>
          <input type="text" id="username" name="username" class="form-input" required>
        </div>
        
        <div class="form-group">
          <label class="form-label" for="password">Password <span id="pwd-help" style="display:none; font-size:0.75rem; color:var(--text-secondary)">(Kosongkan jika tidak diubah)</span></label>
          <input type="password" id="password" name="password" class="form-input">
        </div>
        
        <div class="form-group">
          <label class="form-label" for="role">Hak Akses (Role)</label>
          <select id="role" name="role" class="form-input" required>
            <option value="admin">Administrator / Admin</option>
            <option value="editor">Editor (Bisa edit/publish post lain)</option>
            <option value="author">Author (Hanya bisa tulis post sendiri)</option>
          </select>
        </div>
        
        <div style="margin-top:2rem; display:flex; justify-content:flex-end; gap:1rem">
          <button type="button" class="btn btn-outline" onclick="closeModal('modal-form')">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Data</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
function openFormModal() {
    document.getElementById('modal-title').innerText = 'Tambah Pengguna';
    document.getElementById('form-data').action = '{{ route('admin.users.store') }}';
    document.getElementById('form-method').value = 'POST';
    
    document.getElementById('nama').value = '';
    document.getElementById('username').value = '';
    document.getElementById('password').value = '';
    document.getElementById('password').required = true;
    document.getElementById('pwd-help').style.display = 'none';
    document.getElementById('role').value = 'author';
    
    window.openModal('modal-form');
}

function editData(data) {
    document.getElementById('modal-title').innerText = 'Edit Pengguna';
    document.getElementById('form-data').action = '/admin/users/' + data.id;
    document.getElementById('form-method').value = 'PUT';
    
    document.getElementById('nama').value = data.nama;
    document.getElementById('username').value = data.username;
    document.getElementById('password').value = '';
    document.getElementById('password').required = false;
    document.getElementById('pwd-help').style.display = 'inline';
    document.getElementById('role').value = data.role;
    
    window.openModal('modal-form');
}
</script>
@endpush
