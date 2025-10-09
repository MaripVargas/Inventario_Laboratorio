{{-- Este archivo NO debe tener @extends ni layout, es SOLO el formulario --}}

<form action="{{ route('inventario.update', $item->id) }}" method="POST" enctype="multipart/form-data" id="editForm">
    @csrf
    @method('PUT')

    <div class="row g-3">
        <!-- IR ID (Obligatorio) -->
        <div class="col-md-4">
            <label class="form-label fw-semibold">
                IR ID <span class="text-danger">*</span>
            </label>
            <input 
                type="text" 
                name="ir_id" 
                value="{{ old('ir_id', $item->ir_id) }}" 
                class="form-control @error('ir_id') is-invalid @enderror"
                required>
            @error('ir_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Código Regional -->
        <div class="col-md-4">
            <label class="form-label fw-semibold">Código Regional</label>
            <input 
                type="text" 
                name="cod_regional" 
                value="{{ old('cod_regional', $item->cod_regional) }}" 
                class="form-control @error('cod_regional') is-invalid @enderror">
            @error('cod_regional')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Código Centro -->
        <div class="col-md-4">
            <label class="form-label fw-semibold">Código Centro</label>
            <input 
                type="text" 
                name="cod_centro" 
                value="{{ old('cod_centro', $item->cod_centro) }}" 
                class="form-control @error('cod_centro') is-invalid @enderror">
            @error('cod_centro')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Descripción Almacén -->
        <div class="col-md-6">
            <label class="form-label fw-semibold">Descripción Almacén</label>
            <input 
                type="text" 
                name="desc_almacen" 
                value="{{ old('desc_almacen', $item->desc_almacen) }}" 
                class="form-control @error('desc_almacen') is-invalid @enderror">
            @error('desc_almacen')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- No. Placa (Obligatorio) -->
        <div class="col-md-6">
            <label class="form-label fw-semibold">
                No. Placa <span class="text-danger">*</span>
            </label>
            <input 
                type="text" 
                name="no_placa" 
                value="{{ old('no_placa', $item->no_placa) }}" 
                class="form-control @error('no_placa') is-invalid @enderror"
                required>
            @error('no_placa')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Consecutivo -->
        <div class="col-md-6">
            <label class="form-label fw-semibold">Consecutivo</label>
            <input 
                type="text" 
                name="consecutivo" 
                value="{{ old('consecutivo', $item->consecutivo) }}" 
                class="form-control @error('consecutivo') is-invalid @enderror">
            @error('consecutivo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Descripción SKU (Obligatorio) -->
        <div class="col-md-6">
            <label class="form-label fw-semibold">
                Descripción SKU <span class="text-danger">*</span>
            </label>
            <input 
                type="text" 
                name="desc_sku" 
                value="{{ old('desc_sku', $item->desc_sku) }}" 
                class="form-control @error('desc_sku') is-invalid @enderror"
                required>
            @error('desc_sku')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Descripción del Elemento (Obligatorio) -->
        <div class="col-md-12">
            <label class="form-label fw-semibold">
                Descripción del Elemento <span class="text-danger">*</span>
            </label>
            <textarea 
                name="descripcion_elemento" 
                rows="2" 
                class="form-control @error('descripcion_elemento') is-invalid @enderror"
                required>{{ old('descripcion_elemento', $item->descripcion_elemento) }}</textarea>
            @error('descripcion_elemento')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Atributos -->
        <div class="col-md-6">
            <label class="form-label fw-semibold">Atributos</label>
            <textarea 
                name="atributos" 
                rows="2" 
                class="form-control @error('atributos') is-invalid @enderror">{{ old('atributos', $item->atributos) }}</textarea>
            @error('atributos')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Serial -->
        <div class="col-md-6">
            <label class="form-label fw-semibold">Serial</label>
            <input 
                type="text" 
                name="serial" 
                value="{{ old('serial', $item->serial) }}" 
                class="form-control @error('serial') is-invalid @enderror">
            @error('serial')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Fecha de Adquisición (Obligatorio) -->
        <div class="col-md-6">
            <label class="form-label fw-semibold">
                Fecha de Adquisición <span class="text-danger">*</span>
            </label>
            <input 
                type="date" 
                name="fecha_adq" 
                value="{{ old('fecha_adq', $item->fecha_adq ? $item->fecha_adq->format('Y-m-d') : '') }}"
                class="form-control @error('fecha_adq') is-invalid @enderror" 
                required>
            @error('fecha_adq')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Valor de Adquisición (Obligatorio) -->
        <div class="col-md-6">
            <label class="form-label fw-semibold">
                Valor de Adquisición <span class="text-danger">*</span>
            </label>
            <input 
                type="number" 
                step="0.01" 
                name="valor_adq" 
                value="{{ old('valor_adq', $item->valor_adq) }}" 
                class="form-control @error('valor_adq') is-invalid @enderror"
                required>
            @error('valor_adq')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Gestión -->
        <div class="col-md-6">
            <label class="form-label fw-semibold">Gestión</label>
            <input 
                type="text" 
                name="gestion" 
                value="{{ old('gestion', $item->gestion) }}" 
                class="form-control @error('gestion') is-invalid @enderror">
            @error('gestion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Acciones -->
        <div class="col-md-6">
            <label class="form-label fw-semibold">Acciones</label>
            <textarea 
                name="acciones" 
                rows="2" 
                class="form-control @error('acciones') is-invalid @enderror">{{ old('acciones', $item->acciones) }}</textarea>
            @error('acciones')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Foto -->
        <div class="col-md-6">
            <label class="form-label fw-semibold">Foto</label>
            <input 
                type="file" 
                name="foto" 
                class="form-control @error('foto') is-invalid @enderror"
                accept="image/*">
            @error('foto')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            @if($item->foto)
    <div class="mt-2">
        <img src="{{ asset('storage/'.$item->foto) }}" 
             alt="Foto actual" 
             width="100" 
             class="rounded shadow-sm border">
        <small class="d-block text-muted mt-1">Foto actual</small>
    </div>
@endif
 

        <!-- Estado (Obligatorio) -->
        <div class="col-md-6">
            <label class="form-label fw-semibold">
                Estado <span class="text-danger">*</span>
            </label>
            <select 
                name="estado" 
                class="form-select @error('estado') is-invalid @enderror"
                required>
                <option value="">Seleccione un estado</option>
                <option value="bueno" {{ old('estado', $item->estado) == 'bueno' ? 'selected' : '' }}>Bueno</option>
                <option value="regular" {{ old('estado', $item->estado) == 'regular' ? 'selected' : '' }}>Regular</option>
                <option value="malo" {{ old('estado', $item->estado) == 'malo' ? 'selected' : '' }}>Malo</option>
            </select>
            @error('estado')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <!-- Nota de campos obligatorios -->
    <div class="alert alert-info mt-3 mb-0">
        <i class="fas fa-info-circle me-2"></i>
        <small>Los campos marcados con <span class="text-danger">*</span> son obligatorios</small>
    </div>

    <!-- Botones -->
    <div class="d-flex justify-content-end gap-2 mt-4">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>Cancelar
        </button>
        <button type="submit" class="btn btn-danger">
            <i class="fas fa-save me-1"></i>Guardar Cambios
        </button>
    </div>
</form>