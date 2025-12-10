@extends('client.layouts.app')

@section('title', 'Daily Progress Updates')

@section('content_header')
    <h1 class="mb-3"><i class="fas fa-users"></i> Daily Progress Updates</h1>
@endsection

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @forelse($dailyUpdates as $update)
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-body d-flex">
                        <!-- Photo -->
                        <div class="me-3">
                            @if($update->photo)
                                <img src="{{ asset('storage/' . $update->photo) }}" alt="photo"
                                     style="width:60px;height:60px;object-fit:cover;border-radius:50%;border:2px solid #e9ecef;">
                            @else
                                <div style="width:60px;height:60px;border-radius:50%;background:#e9ecef;display:flex;align-items:center;justify-content:center;color:#6c757d;">
                                    N/A
                                </div>
                            @endif
                        </div>

                        <div class="flex-fill">
                            <p class="fw-bold mb-2">{{ $update->progress_description }}</p>
                            <div class="text-muted small mb-2">
                                👷 Labour: <strong>{{ $update->labour_count ?? 'N/A' }}</strong> |
                                ⏱ Hours: <strong>{{ $update->work_hours ?? 'N/A' }}</strong> |
                                📌 Status: <strong>{{ $update->status ?? 'N/A' }}</strong>
                            </div>
                            <button type="button" class="btn btn-primary btn-sm" onclick="openModal('modal-{{ $update->id }}')">
                                <i class="fas fa-eye"></i> View Details
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div id="modal-{{ $update->id }}" class="custom-modal">
                <div class="custom-modal-overlay" onclick="closeModal('modal-{{ $update->id }}')"></div>
                <div class="custom-modal-content">
                    <button class="custom-close" onclick="closeModal('modal-{{ $update->id }}')">&times;</button>
                    <h5 class="mb-3"><i class="fas fa-info-circle"></i> Progress Details</h5>

                    <div class="row small mb-3">
                        <div class="col-sm-6"><strong>Date:</strong> {{ $update->date }}</div>
                        <div class="col-sm-6"><strong>Project ID:</strong> {{ $update->project_id }}</div>
                        <div class="col-sm-6"><strong>Task:</strong> {{ $update->task_title }}</div>
                        <div class="col-sm-6"><strong>Work Hours:</strong> {{ $update->work_hours ?? 'N/A' }}</div>
                        <div class="col-sm-6"><strong>Labour Count:</strong> {{ $update->labour_count ?? 'N/A' }}</div>
                        <div class="col-sm-6"><strong>Status:</strong> {{ $update->status ?? 'N/A' }}</div>
                    </div>

                    <p><strong>Description:</strong> {{ $update->progress_description }}</p>
                    <p><strong>Work Done:</strong> {{ $update->work_done }}</p>

                    <div class="row">
                        <div class="col-md-6">
                            <p class="fw-bold">Before Photo</p>
                            @if($update->before_photo)
                                <img src="{{ asset('storage/' . $update->before_photo) }}" class="img-fluid rounded shadow-sm">
                            @else
                                <p class="text-muted">No before photo</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <p class="fw-bold">After Photo</p>
                            @if($update->after_photo)
                                <img src="{{ asset('storage/' . $update->after_photo) }}" class="img-fluid rounded shadow-sm">
                            @else
                                <p class="text-muted">No after photo</p>
                            @endif
                        </div>
                    </div>

                    <div class="text-end mt-3">
                        <button class="btn btn-secondary" onclick="closeModal('modal-{{ $update->id }}')">Close</button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">No updates found.</div>
            </div>
        @endforelse
    </div>
</div>

<!-- Inline CSS (ignores AdminLTE/Bootstrap conflicts) -->
<style>
.custom-modal {
    position: fixed; inset: 0; display: none;
    align-items: center; justify-content: center;
    z-index: 9999;
}
.custom-modal.show { display: flex; }
.custom-modal-overlay {
    position: absolute; inset: 0; background: rgba(0,0,0,0.6);
}
.custom-modal-content {
    position: relative;
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    max-width: 900px;
    width: 95%;
    max-height: 90vh;
    overflow-y: auto;
    z-index: 10000;
}
.custom-close {
    position: absolute; top: 10px; right: 15px;
    background: none; border: none; font-size: 28px;
    cursor: pointer; color: #333;
}
</style>

<!-- Inline JS -->
<script>
function openModal(id) {
    document.getElementById(id).classList.add('show');
    document.body.style.overflow = 'hidden'; // prevent background scroll
}
function closeModal(id) {
    document.getElementById(id).classList.remove('show');
    document.body.style.overflow = ''; // restore scroll
}
</script>
@endsection
