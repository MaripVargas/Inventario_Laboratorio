<form action="{{ route('zoologia.reactivos.update', $item->id) }}" method="POST" id="editForm">
    @csrf
    @method('PUT')

    <div class="form-fields">
        <div class="col-12">
            <div class="section-header">
                <i class="fas fa-vial"></i>
                <h6>Editar Reactivo</h6>
            </div>
        </div>

        <!-- Nombre -->
        <div class="form-group">
            <label class="form-label">
                Nombre del Reactivo 
                <span class="required">*</span>
            </label>
            <input 
                type="text" 
                name="nombre_reactivo" 
                value="{{ old('nombre_reactivo', $item->nombre_reactivo) }}" 
                class="form-control @error('nombre_reactivo') is-invalid @enderror" 
                required
                placeholder="Ingrese el nombre del reactivo">
            @error('nombre_reactivo') 
                <div class="invalid-feedback">{{ $message }}</div> 
            @enderror
        </div>

        <!-- Cantidad -->
        <div class="form-group">
            <label class="form-label">Cantidad</label>
            <input 
                type="number" 
                name="cantidad" 
                value="{{ old('cantidad', $item->cantidad) }}" 
                class="form-control @error('cantidad') is-invalid @enderror"
                placeholder="0"
                step="0.01">
            @error('cantidad') 
                <div class="invalid-feedback">{{ $message }}</div> 
            @enderror
        </div>

        <!-- Unidad -->
        <div class="form-group">
            <label class="form-label">Unidad</label>
            <input 
                type="text" 
                name="unidad" 
                value="{{ old('unidad', $item->unidad) }}" 
                class="form-control @error('unidad') is-invalid @enderror"
                placeholder="ml, gr, lt, etc.">
            @error('unidad') 
                <div class="invalid-feedback">{{ $message }}</div> 
            @enderror
        </div>

        <!-- Concentración -->
        <div class="form-group full-width">
            <label class="form-label">Concentración</label>
            <input 
                type="text" 
                name="concentracion" 
                value="{{ old('concentracion', $item->concentracion) }}" 
                class="form-control @error('concentracion') is-invalid @enderror"
                placeholder="Ej: 0.5M, 10%, etc.">
            @error('concentracion') 
                <div class="invalid-feedback">{{ $message }}</div> 
            @enderror
        </div>

        <!-- Detalle -->
        <div class="form-group full-width">
            <label class="form-label">Detalle</label>
            <textarea 
                name="detalle" 
                rows="3" 
                class="form-control @error('detalle') is-invalid @enderror"
                placeholder="Información adicional sobre el reactivo...">{{ old('detalle', $item->detalle) }}</textarea>
            @error('detalle') 
                <div class="invalid-feedback">{{ $message }}</div> 
            @enderror
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
            <i class="fas fa-times me-2"></i>
            Cancelar
        </button>
        <button type="submit" class="btn btn-save">
            <i class="fas fa-check me-2"></i>
            Guardar Cambios
        </button>
    </div>
</form>

<style>
/* ============================
   VARIABLES Y RESET
   ============================ */
:root {
    --primary: #3b82f6;
    --danger: #ef4444;
    --success: #10b981;
    --gray-50: #f9fafb;
    --gray-100: #f3f4f6;
    --gray-200: #e5e7eb;
    --gray-300: #d1d5db;
    --gray-500: #6b7280;
    --gray-700: #374151;
    --gray-900: #111827;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

/* ============================
   MODAL CONTAINER
   ============================ */
#editModal .modal-content {
    border-radius: 20px;
    overflow: hidden;
    border: none;
    box-shadow: var(--shadow-xl);
    animation: modalSlideIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-20px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* ============================
   MODAL HEADER
   ============================ */
#editModal .modal-header {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    padding: 1.5rem 1.75rem;
    border-bottom: none;
    position: relative;
    overflow: hidden;
}

#editModal .modal-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at top right, rgba(255, 255, 255, 0.1) 0%, transparent 60%);
    pointer-events: none;
}

#editModal .modal-title {
    font-weight: 600;
    font-size: 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    position: relative;
    z-index: 1;
}

#editModal .modal-title i {
    font-size: 1.5rem;
    opacity: 0.9;
}

#editModal .btn-close {
    filter: brightness(0) invert(1);
    opacity: 0.9;
    transition: all 0.3s ease;
    position: relative;
    z-index: 1;
}

#editModal .btn-close:hover {
    opacity: 1;
    transform: rotate(90deg);
}

/* ============================
   MODAL BODY
   ============================ */
#editModal .modal-body {
    background: var(--gray-50);
    padding: 2rem 1.75rem;
    max-height: 70vh;
    overflow-y: auto;
}

/* Scrollbar personalizado */
#editModal .modal-body::-webkit-scrollbar {
    width: 8px;
}

#editModal .modal-body::-webkit-scrollbar-track {
    background: var(--gray-100);
    border-radius: 10px;
}

#editModal .modal-body::-webkit-scrollbar-thumb {
    background: var(--gray-300);
    border-radius: 10px;
    transition: background 0.3s ease;
}

#editModal .modal-body::-webkit-scrollbar-thumb:hover {
    background: var(--gray-500);
}

/* ============================
   SPINNER DE CARGA
   ============================ */
#editModal #loadingSpinner {
    text-align: center;
    padding: 4rem 2rem;
}

#editModal #loadingSpinner .spinner-border {
    width: 3.5rem;
    height: 3.5rem;
    color: var(--danger);
    border-width: 4px;
}

#editModal #loadingSpinner p {
    margin-top: 1.5rem;
    color: var(--gray-500);
    font-size: 0.9375rem;
    font-weight: 500;
}

/* ============================
   FORMULARIO
   ============================ */
#editForm .form-fields {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1.5rem;
}

.section-header {
    grid-column: 1 / -1;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 1.25rem;
    background: white;
    border-radius: 12px;
    border-left: 4px solid var(--danger);
    margin-bottom: 0.5rem;
    box-shadow: var(--shadow-sm);
}

.section-header i {
    font-size: 1.25rem;
    color: var(--danger);
}

.section-header h6 {
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
    color: var(--gray-900);
}

/* ============================
   CAMPOS DE FORMULARIO
   ============================ */
.form-group {
    display: flex;
    flex-direction: column;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-label {
    font-weight: 600;
    font-size: 0.875rem;
    color: var(--gray-700);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.form-label .required {
    color: var(--danger);
    font-weight: bold;
}

.form-control {
    width: 100%;
    border: 2px solid var(--gray-200);
    border-radius: 12px;
    padding: 0.75rem 1rem;
    background: white;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    font-size: 0.9375rem;
    color: var(--gray-900);
    box-shadow: var(--shadow-sm);
}

.form-control::placeholder {
    color: var(--gray-400);
}

.form-control:focus {
    outline: none;
    border-color: var(--danger);
    box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1), var(--shadow-md);
    transform: translateY(-2px);
}

.form-control:hover:not(:focus) {
    border-color: var(--gray-300);
}

textarea.form-control {
    resize: vertical;
    min-height: 80px;
    font-family: inherit;
}

/* Estados de validación */
.form-control.is-invalid {
    border-color: var(--danger);
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23ef4444' viewBox='0 0 16 16'%3E%3Cpath d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/%3E%3Cpath d='M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 1.125rem;
    padding-right: 3rem;
}

.invalid-feedback {
    display: block;
    margin-top: 0.5rem;
    font-size: 0.8125rem;
    color: var(--danger);
    font-weight: 500;
    padding-left: 0.25rem;
}

/* ============================
   FOOTER DEL MODAL
   ============================ */
#editModal .modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    padding: 1.5rem 1.75rem;
    border-top: 1px solid var(--gray-200);
    background: white;
}

#editModal .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.9375rem;
    border-radius: 12px;
    padding: 0.75rem 1.75rem;
    border: none;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

#editModal .btn::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

#editModal .btn:active::before {
    width: 300px;
    height: 300px;
}

.btn-cancel {
    background: var(--gray-100);
    color: var(--gray-700);
}

.btn-cancel:hover {
    background: var(--gray-200);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.btn-save {
    background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
    color: white;
    box-shadow: var(--shadow-md);
}

.btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 20px -5px rgba(16, 185, 129, 0.4);
}

/* ============================
   RESPONSIVE
   ============================ */
@media (max-width: 768px) {
    #editForm .form-fields {
        grid-template-columns: 1fr;
        gap: 1.25rem;
    }
    
    #editModal .modal-body {
        padding: 1.5rem 1.25rem;
    }
    
    #editModal .modal-header {
        padding: 1.25rem 1.5rem;
    }
    
    #editModal .modal-footer {
        flex-direction: column;
        gap: 0.75rem;
        padding: 1.25rem 1.5rem;
    }
    
    #editModal .btn {
        width: 100%;
    }
}

/* ============================
   ANIMACIONES ADICIONALES
   ============================ */
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

.form-control.is-invalid {
    animation: shake 0.4s ease-in-out;
}

/* Efecto de entrada para campos */
.form-group {
    animation: fadeInUp 0.5s ease-out backwards;
}

.form-group:nth-child(1) { animation-delay: 0.05s; }
.form-group:nth-child(2) { animation-delay: 0.1s; }
.form-group:nth-child(3) { animation-delay: 0.15s; }
.form-group:nth-child(4) { animation-delay: 0.2s; }
.form-group:nth-child(5) { animation-delay: 0.25s; }
.form-group:nth-child(6) { animation-delay: 0.3s; }

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>