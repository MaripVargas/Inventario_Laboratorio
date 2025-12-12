{{-- Este archivo NO debe tener @extends ni layout, es SOLO el formulario --}}

<form action="{{ route('inventario.update', $item->id) }}" method="POST" enctype="multipart/form-data" id="editForm">
    @csrf
    @method('PUT')

    <div class="row g-3">
        <!-- ====== SECCIÓN: IDENTIFICACIÓN ====== -->
        <div class="col-12">
            <h6 class="text-muted border-bottom pb-2 mb-3">
                <i class="fas fa-id-card me-2"></i>Identificación
            </h6>
        </div>

        <!-- IR ID (Obligatorio) -->
        <div class="col-md-4">
            <label class="form-label fw-semibold">
                IR ID <span class="text-danger">*</span>
            </label>
            <input type="text" name="ir_id" value="{{ old('ir_id', $item->ir_id) }}"
                class="form-control @error('ir_id') is-invalid @enderror" required>
            @error('ir_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- IV ID -->
        <div class="col-md-4">
            <label class="form-label fw-semibold">IV ID</label>
            <input type="text" name="iv_id" value="{{ old('iv_id', $item->iv_id) }}"
                class="form-control @error('iv_id') is-invalid @enderror">
            @error('iv_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- No. Placa (Obligatorio) -->
        <div class="col-md-4">
            <label class="form-label fw-semibold">
                No. Placa <span class="text-danger">*</span>
            </label>
            <input type="text" name="no_placa" value="{{ old('no_placa', $item->no_placa) }}"
                class="form-control @error('no_placa') is-invalid @enderror" required>
            @error('no_placa')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Código Regional -->
        <div class="col-md-4">
            <label class="form-label fw-semibold">Código Regional</label>
            <input type="text" name="cod_regional" value="{{ old('cod_regional', $item->cod_regional) }}"
                class="form-control @error('cod_regional') is-invalid @enderror">
            @error('cod_regional')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Código Centro -->
        <div class="col-md-4">
            <label class="form-label fw-semibold">Código Centro</label>
            <input type="text" name="cod_centro" value="{{ old('cod_centro', $item->cod_centro) }}"
                class="form-control @error('cod_centro') is-invalid @enderror">
            @error('cod_centro')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Consecutivo -->
        <div class="col-md-4">
            <label class="form-label fw-semibold">Consecutivo</label>
            <input type="text" name="consecutivo" value="{{ old('consecutivo', $item->consecutivo) }}"
                class="form-control @error('consecutivo') is-invalid @enderror">
            @error('consecutivo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Descripción Almacén -->
        <div class="col-md-12">
            <label class="form-label fw-semibold">Ubicacion</label>
            <input type="text" name="desc_almacen" value="{{ old('desc_almacen', $item->desc_almacen) }}"
                class="form-control @error('desc_almacen') is-invalid @enderror">
            @error('desc_almacen')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- ====== SECCIÓN: DESCRIPCIÓN DEL ELEMENTO ====== -->
        <div class="col-12">
            <h6 class="text-muted border-bottom pb-2 mb-3 mt-3">
                <i class="fas fa-box me-2"></i>Descripción del Elemento
            </h6>
        </div>

        <!-- Descripción SKU (Obligatorio) -->
        <div class="col-md-6">
            <label class="form-label fw-semibold">
                Descripción SKU <span class="text-danger">*</span>
            </label>
            <input type="text" name="desc_sku" value="{{ old('desc_sku', $item->desc_sku) }}"
                class="form-control @error('desc_sku') is-invalid @enderror" required>
            @error('desc_sku')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Tipo de Material (Obligatorio) -->
        <div class="col-md-6">
            <label class="form-label fw-semibold">
                Tipo de Material <span class="text-danger">*</span>
            </label>
            <select name="tipo_material" class="form-select @error('tipo_material') is-invalid @enderror" required>
                @php($tipoMaterial = old('tipo_material', $item->tipo_material))
                <option value="">Seleccione tipo</option>
                <option value="Equipos" {{ $tipoMaterial == 'Equipos' ? 'selected' : '' }}>Equipos</option>
                <option value="Mueblería" {{ $tipoMaterial == 'Mueblería' ? 'selected' : '' }}>Mueblería</option>
            </select>
            @error('tipo_material')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Descripción del Elemento (Obligatorio) -->
        <div class="col-md-12">
            <label class="form-label fw-semibold">
                Descripción del Elemento <span class="text-danger">*</span>
            </label>
            <textarea name="descripcion_elemento" rows="2"
                class="form-control @error('descripcion_elemento') is-invalid @enderror"
                required>{{ old('descripcion_elemento', $item->descripcion_elemento) }}</textarea>
            @error('descripcion_elemento')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Atributos -->
        <div class="col-md-6">
            <label class="form-label fw-semibold">Atributos</label>
            <textarea name="atributos" rows="2"
                class="form-control @error('atributos') is-invalid @enderror">{{ old('atributos', $item->atributos) }}</textarea>
            @error('atributos')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Serial -->
        <div class="col-md-6">
            <label class="form-label fw-semibold">Serial</label>
            <input type="text" name="serial" value="{{ old('serial', $item->serial) }}"
                class="form-control @error('serial') is-invalid @enderror">
            @error('serial')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- ====== SECCIÓN: ADQUISICIÓN ====== -->
        <div class="col-12">
            <h6 class="text-muted border-bottom pb-2 mb-3 mt-3">
                <i class="fas fa-shopping-cart me-2"></i>Información de Adquisición
            </h6>
        </div>

        <!-- Fecha de Adquisición (Obligatorio) -->
        <div class="col-md-4">
            <label class="form-label fw-semibold">
                Fecha de Adquisición <span class="text-danger">*</span>
            </label>
            <input type="date" name="fecha_adq"
                value="{{ old('fecha_adq', $item->fecha_adq ? $item->fecha_adq->format('Y-m-d') : '') }}"
                class="form-control @error('fecha_adq') is-invalid @enderror" required>
            @error('fecha_adq')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Valor de Adquisición (Obligatorio) -->
        <div class="col-md-4">
            <label class="form-label fw-semibold">
                Valor de Adquisición <span class="text-danger">*</span>
            </label>
            <input type="number" step="0.01" name="valor_adq" value="{{ old('valor_adq', $item->valor_adq) }}"
                class="form-control @error('valor_adq') is-invalid @enderror" required>
            @error('valor_adq')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Contrato -->
        <div class="col-md-4">
            <label class="form-label fw-semibold">Contrato</label>
            <input type="text" name="contrato" value="{{ old('contrato', $item->contrato) }}"
                class="form-control @error('contrato') is-invalid @enderror">
            @error('contrato')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- ====== SECCIÓN: GESTIÓN Y USO ====== -->
        <div class="col-12">
            <h6 class="text-muted border-bottom pb-2 mb-3 mt-3">
                <i class="fas fa-cogs me-2"></i>Gestión y Uso
            </h6>
        </div>

        <!-- Gestión -->
        <div class="col-md-4">
            <label class="form-label fw-semibold">
                Fecha Mantenimiento <span class="text-danger">*</span>
            </label>
            <input type="date" name="fecha_mant"
                value="{{ old('fecha_mant', $item->fecha_mant ? $item->fecha_mant->format('Y-m-d') : '') }}"
                class="form-control @error('fecha_mant') is-invalid @enderror">
            @error('fecha_mant')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Uso -->
        <div class="col-md-4">
            <label class="form-label fw-semibold">Uso</label>
            <select name="uso" class="form-select @error('uso') is-invalid @enderror">
                @php($usoValue = old('uso', $item->uso))
                <option value="">Seleccione</option>
                <option value="Formacion" {{ $usoValue == 'Formacion' ? 'selected' : '' }}>Formación</option>
                <option value="investigacion" {{ $usoValue == 'investigacion' ? 'selected' : '' }}>Servicios Tecnológicos
                </option>
                <option value="administracion" {{ $usoValue == 'administracion' ? 'selected' : '' }}>Investigación
                </option>
            </select>
            @error('uso')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Estado (Obligatorio) -->
        <div class="col-md-4">
            <label class="form-label fw-semibold">
                Estado <span class="text-danger">*</span>
            </label>
            <select name="estado" class="form-select @error('estado') is-invalid @enderror" required>
                <option value="">Seleccione un estado</option>
                <option value="bueno" {{ old('estado', $item->estado) == 'bueno' ? 'selected' : '' }}>Bueno</option>
                <option value="regular" {{ old('estado', $item->estado) == 'regular' ? 'selected' : '' }}>Regular</option>
                <option value="malo" {{ old('estado', $item->estado) == 'malo' ? 'selected' : '' }}>Malo</option>
            </select>
            @error('estado')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- ====== SECCIÓN: RESPONSABLE ====== -->
        <div class="col-12">
            <h6 class="text-muted border-bottom pb-2 mb-3 mt-3">
                <i class="fas fa-user me-2"></i>Información del Responsable
            </h6>
        </div>

        <!-- Nombre Responsable -->
        <div class="col-md-4">
            <label class="form-label fw-semibold">Nombre del Responsable</label>
            <select name="nombre_responsable" id="nombre_responsable"
                class="form-select @error('nombre_responsable') is-invalid @enderror">
                <option value="">Seleccione</option>
                @php($nombreActual = old('nombre_responsable', $item->nombre_responsable))
                @foreach(($responsables ?? []) as $resp)
                @php($n = is_array($resp) ? ($resp['nombre_responsable'] ?? '') : ($resp->nombre_responsable ?? ''))
                @php($c = is_array($resp) ? ($resp['cedula'] ?? '') : ($resp->cedula ?? ''))
                @if($n)
                    <option value="{{ $n }}" data-cedula="{{ $c }}" {{ $nombreActual == $n ? 'selected' : '' }}>
                        {{ $n }}
                    </option>
                @endif
                @endforeach
                @if(($responsables ?? collect())->where('nombre_responsable', $nombreActual)->isEmpty() && $nombreActual)
                    <option value="{{ $nombreActual }}" data-cedula="{{ old('cedula', $item->cedula) }}" selected>
                        {{ $nombreActual }}</option>
                @endif
            </select>
            @error('nombre_responsable')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Cédula -->
        <div class="col-md-4">
            <label class="form-label fw-semibold">Cédula</label>
            <input type="text" name="cedula" id="cedula" value="{{ old('cedula', $item->cedula) }}"
                class="form-control @error('cedula') is-invalid @enderror">
            @error('cedula')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Vinculación -->
        <div class="col-md-4">
            <label class="form-label fw-semibold">Vinculación</label>
            <select name="vinculacion" class="form-select @error('vinculacion') is-invalid @enderror">
                @php($vincValue = old('vinculacion', $item->vinculacion))
                <option value="">Seleccione</option>
                <option value="contrato" {{ $vincValue == 'contrato' ? 'selected' : '' }}>Contrato</option>
                <option value="Funcionario Administrativo" {{ $vincValue == 'Funcionario Administrativo' ? 'selected' : '' }}>Funcionario Administrativo</option>
                <option value="Planta" {{ $vincValue == 'Planta' ? 'selected' : '' }}>Planta</option>
            </select>
            @error('vinculacion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- ====== SECCIÓN: REGISTRO Y AUDITORÍA ====== -->
        <div class="col-12">
            <h6 class="text-muted border-bottom pb-2 mb-3 mt-3">
                <i class="fas fa-clock me-2"></i>Información de Registro
            </h6>
        </div>

        <!-- Fecha Registro -->
        <div class="col-md-6">
            <label class="form-label fw-semibold">Fecha Registro</label>
            <input type="datetime-local" name="fecha_registro"
                value="{{ old('fecha_registro', $item->fecha_registro ? $item->fecha_registro->format('Y-m-d\TH:i') : '') }}"
                class="form-control @error('fecha_registro') is-invalid @enderror">
            @error('fecha_registro')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Usuario Registra -->
        <div class="col-md-6">
            <label class="form-label fw-semibold">Usuario Registra</label>
            <input type="text" name="usuario_registra" value="{{ old('usuario_registra', $item->usuario_registra) }}"
                class="form-control @error('usuario_registra') is-invalid @enderror">
            @error('usuario_registra')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- ====== SECCIÓN: MULTIMEDIA ====== -->
        <div class="col-12">
            <h6 class="text-muted border-bottom pb-2 mb-3 mt-3">
                <i class="fas fa-image me-2"></i>Fotografía
            </h6>
        </div>

        <!-- Foto -->
        <div class="col-md-12">
            <label class="form-label fw-semibold">Foto</label>
            <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
            @error('foto')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            @if($item->foto)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto actual" width="100"
                        class="rounded shadow-sm border">
                    <small class="d-block text-muted mt-1">Foto actual</small>
                </div>
            @endif
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