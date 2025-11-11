<form action="{{ route('biotecnologia.vidrieria.update', $item->id) }}" method="POST" id="editForm">
    @csrf
    @method('PUT')

    <div class="row g-3">
        <div class="col-12">
            <h6 class="text-muted border-bottom pb-2 mb-3">
                <i class="fas fa-flask me-2"></i>Editar artículo de vidriería
            </h6>
        </div>

        <!-- Nombre -->
        <div class="col-md-6">
            <label class="form-label fw-semibold">Nombre del Artículo <span class="text-danger">*</span></label>
            <input type="text" name="nombre_item" value="{{ old('nombre_item', $item->nombre_item) }}" class="form-control @error('nombre_item') is-invalid @enderror" required>
            @error('nombre_item') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Volumen -->
        <div class="col-md-3">
            <label class="form-label fw-semibold">Volumen</label>
            <input type="text" name="volumen" value="{{ old('volumen', $item->volumen) }}" class="form-control @error('volumen') is-invalid @enderror">
            @error('volumen') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Cantidad -->
        <div class="col-md-3">
            <label class="form-label fw-semibold">Cantidad</label>
            <input type="number" name="cantidad" value="{{ old('cantidad', $item->cantidad) }}" class="form-control @error('cantidad') is-invalid @enderror">
            @error('cantidad') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Unidad -->
        <div class="col-md-3">
            <label class="form-label fw-semibold">Unidad</label>
            <input type="text" name="unidad" value="{{ old('unidad', $item->unidad) }}" class="form-control @error('unidad') is-invalid @enderror">
            @error('unidad') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Detalle -->
        <div class="col-md-12">
            <label class="form-label fw-semibold">Detalle</label>
            <textarea name="detalle" rows="2" class="form-control @error('detalle') is-invalid @enderror">{{ old('detalle', $item->detalle) }}</textarea>
            @error('detalle') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-4">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Cancelar</button>
        <button type="submit" class="btn btn-danger"><i class="fas fa-save me-1"></i>Guardar Cambios</button>
    </div>
</form>
<style>
    /* ============================
   MODAL DE EDICIÓN MODERNO
   ============================ */
#editModal .modal-content {
    border-radius: 16px;
    overflow: hidden;
    border: none;
    box-shadow: var(--shadow-xl);
    animation: fadeInUp 0.5s ease-out;
}

#editModal .modal-header {
    background: linear-gradient(135deg, var(--danger-color), #f87171);
    color: white;
    padding: 1rem 1.25rem;
    border-bottom: none;
}

#editModal .modal-title {
    font-weight: 600;
    font-size: 1.125rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

#editModal .btn-close {
    filter: invert(1);
    opacity: 0.8;
    transition: opacity 0.2s ease;
}

#editModal .btn-close:hover {
    opacity: 1;
}

#editModal .modal-body {
    background: var(--gray-50);
    padding: 1.5rem;
    max-height: 75vh;
    overflow-y: auto;
}

/* Spinner de carga */
#editModal #loadingSpinner {
    text-align: center;
    padding: 3rem 0;
}

#editModal #loadingSpinner .spinner-border {
    width: 3rem;
    height: 3rem;
    color: var(--danger-color);
}

#editModal #loadingSpinner p {
    margin-top: 1rem;
    color: var(--gray-500);
    font-size: 0.875rem;
}

/* Formularios dentro del modal */
#editModal form {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 1rem;
}

#editModal label {
    font-weight: 600;
    font-size: 0.875rem;
    color: var(--gray-700);
    margin-bottom: 0.35rem;
}

#editModal input,
#editModal select,
#editModal textarea {
    width: 100%;
    border: 2px solid var(--gray-200);
    border-radius: 10px;
    padding: 0.65rem 0.85rem;
    background: white;
    transition: all 0.3s ease;
    font-size: 0.875rem;
}

#editModal input:focus,
#editModal select:focus,
#editModal textarea:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    transform: translateY(-1px);
}

/* Botones del formulario */
#editModal .modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
    padding: 1rem 1.25rem;
    border-top: 1px solid var(--gray-200);
    background: #fff;
}

#editModal .btn-cancelar {
    background: var(--gray-100);
    color: var(--gray-700);
    font-weight: 500;
    border-radius: 10px;
    padding: 0.6rem 1.25rem;
    border: none;
    transition: all 0.3s ease;
}

#editModal .btn-cancelar:hover {
    background: var(--gray-200);
    transform: translateY(-1px);
}

#editModal .btn-guardar {
    background: linear-gradient(135deg, var(--success-color), #34d399);
    color: white;
    font-weight: 600;
    border-radius: 10px;
    padding: 0.6rem 1.25rem;
    border: none;
    transition: all 0.3s ease;
}

#editModal .btn-guardar:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-2px);
}
</style>

