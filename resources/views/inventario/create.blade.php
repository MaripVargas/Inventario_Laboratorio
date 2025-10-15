@extends('layouts.app')

@section('title', 'Agregar Item')
@section('page-title', 'Agregar Item al Inventario')
@section('page-subtitle', 'Registra un nuevo item en el sistema')

@section('content')
<div class="max-w-6xl mx-auto modern-form-container">
    <div class="card modern-form-card">
        <div class="card-header modern-form-header">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-900">Información del Item</h2>
                <a href="{{ route('inventario.index') }}" class="modern-btn modern-btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Volver
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('inventario.store') }}" method="POST" enctype="multipart/form-data" class="modern-form space-y-6">
                @csrf
                
                <!-- Información Básica -->
                <div class="form-section">
                    <h3 class="form-section-title">
                        <i class="fas fa-info-circle"></i>
                        Información Básica
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="form-group">
                            <label class="form-label">
                                IR ID <span class="required">*</span>
                            </label>
                            <div class="input-container">
                                <i class="fas fa-tag input-icon"></i>
                                <input type="text" name="ir_id" required 
                                       class="form-input"
                                       placeholder="Ej: IR-001" value="{{ old('ir_id') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                IV ID
                            </label>
                            <div class="input-container">
                                <i class="fas fa-barcode input-icon"></i>
                                <input type="text" name="iv_id" 
                                       class="form-input"
                                       placeholder="Ej: IV-001" value="{{ old('iv_id') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                Código Regional <span class="required">*</span>
                            </label>
                            <div class="input-container">
                                <i class="fas fa-map-marker-alt input-icon"></i>
                                <input type="text" name="cod_regional" required 
                                       class="form-input"
                                       placeholder="Ej: REG-001" value="{{ old('cod_regional') }}">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="form-group">
                            <label class="form-label">
                                Código Centro <span class="required">*</span>
                            </label>
                            <div class="input-container">
                                <i class="fas fa-building input-icon"></i>
                                <input type="text" name="cod_centro" required 
                                       class="form-input"
                                       placeholder="Ej: CEN-001" value="{{ old('cod_centro') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                Descripción Almacén <span class="required">*</span>
                            </label>
                            <div class="input-container">
                                <i class="fas fa-warehouse input-icon"></i>
                                <input type="text" name="desc_almacen" required 
                                       class="form-input"
                                       placeholder="Ej: Almacén Principal" value="{{ old('desc_almacen') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                No. de Placa <span class="required">*</span>
                            </label>
                            <div class="input-container">
                                <i class="fas fa-id-card input-icon"></i>
                                <input type="text" name="no_placa" required 
                                       class="form-input"
                                       placeholder="Ej: PL-001" value="{{ old('no_placa') }}">
                            </div>
                        </div>
                    </div>
                </div>
                

                <!-- Información del Producto -->
                <div class="form-section">
                    <h3 class="form-section-title">
                        <i class="fas fa-box"></i>
                        Información del Producto
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label class="form-label">
                                Consecutivo <span class="required">*</span>
                            </label>
                            <div class="input-container">
                                <i class="fas fa-sort-numeric-up input-icon"></i>
                                <input type="text" name="consecutivo" required 
                                       class="form-input"
                                       placeholder="Ej: CON-001" value="{{ old('consecutivo') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                Descripción SKU <span class="required">*</span>
                            </label>
                            <div class="input-container">
                                <i class="fas fa-barcode input-icon"></i>
                                <input type="text" name="desc_sku" required 
                                       class="form-input"
                                       placeholder="Ej: SKU-001" value="{{ old('desc_sku') }}">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label class="form-label">
                                Serial
                            </label>
                            <div class="input-container">
                                <i class="fas fa-microchip input-icon"></i>
                                <input type="text" name="serial" 
                                       class="form-input"
                                       placeholder="Ej: SN123456789" value="{{ old('serial') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                Gestión <span class="required">*</span>
                            </label>
                            <div class="input-container">
                                <i class="fas fa-calendar-alt input-icon"></i>
                                <input type="text" name="gestion" required 
                                       class="form-input"
                                       placeholder="Ej: 2024" value="{{ old('gestion') }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Descripción del Elemento <span class="required">*</span>
                        </label>
                        <div class="textarea-container">
                            <i class="fas fa-align-left textarea-icon"></i>
                            <textarea name="descripcion_elemento" rows="3" required
                                      class="form-textarea"
                                      placeholder="Descripción detallada del elemento...">{{ old('descripcion_elemento') }}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Atributos
                        </label>
                        <div class="textarea-container">
                            <i class="fas fa-list-ul textarea-icon"></i>
                            <textarea name="atributos" rows="3"
                                      class="form-textarea"
                                      placeholder="Atributos adicionales del elemento...">{{ old('atributos') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Información de Adquisición -->
                <div class="form-section">
                    <h3 class="form-section-title">
                        <i class="fas fa-dollar-sign"></i>
                        Información de Adquisición
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label class="form-label">
                                Fecha de Adquisición <span class="required">*</span>
                            </label>
                            <div class="input-container">
                                <i class="fas fa-calendar input-icon"></i>
                                <input type="date" name="fecha_adq" required 
                                       class="form-input"
                                       value="{{ old('fecha_adq') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                Valor de Adquisición <span class="required">*</span>
                            </label>
                            <div class="input-container">
                                <i class="fas fa-dollar-sign input-icon"></i>
                                <input type="number" name="valor_adq" required min="0" step="0.01"
                                       class="form-input"
                                       placeholder="0.00" value="{{ old('valor_adq') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Uso y Contrato -->
                <div class="form-section">
                    <h3 class="form-section-title">
                        <i class="fas fa-clipboard-list"></i>
                        Uso y Contratación
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label class="form-label">
                                Uso <span class="required">*</span>
                            </label>
                            <div class="select-container">
                                <i class="fas fa-layer-group select-icon"></i>
                                <select name="uso" required class="form-select">
                                    <option value="">Seleccionar uso</option>
                                    <option value="formacion" {{ old('uso') == 'formacion' ? 'selected' : '' }}>Formación</option>
                                    <option value="servicios_tecnologicos" {{ old('uso') == 'servicios_tecnologicos' ? 'selected' : '' }}>Servicios Tecnológicos</option>
                                    <option value="investigacion" {{ old('uso') == 'investigacion' ? 'selected' : '' }}>Investigación</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                Contrato/PCN <span class="required">*</span>
                            </label>
                            <div class="input-container">
                                <i class="fas fa-file-contract input-icon"></i>
                                <input type="text" name="contrato" required 
                                       class="form-input"
                                       placeholder="Ej: PCN-2024-001" value="{{ old('contrato') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información del Responsable -->
                <div class="form-section">
                    <h3 class="form-section-title">
                        <i class="fas fa-user-tie"></i>
                        Información del Responsable
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="form-group">
                            <label class="form-label">
                                Nombre Responsable <span class="required">*</span>
                            </label>
                            <div class="select-container">
                                <i class="fas fa-user select-icon"></i>
                                <select name="nombre_responsable" id="nombre_responsable" required class="form-select">
                                    <option value="">Seleccionar responsable</option>
                                    <option value="Carolina" data-cc="1234567890" {{ old('nombre_responsable') == 'Carolina' ? 'selected' : '' }}>Carolina</option>
                                    <option value="Maria" data-cc="0987654321" {{ old('nombre_responsable') == 'Maria' ? 'selected' : '' }}>Maria</option>
                                    <option value="Alcy" data-cc="1122334455" {{ old('nombre_responsable') == 'Alcy' ? 'selected' : '' }}>Alcy</option>
                                    <option value="Yoli" data-cc="5544332211" {{ old('nombre_responsable') == 'Yoli' ? 'selected' : '' }}>Yoli</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                Cédula (C.C) <span class="required">*</span>
                            </label>
                            <div class="input-container">
                                <i class="fas fa-id-card input-icon"></i>
                                <input type="text" name="cedula" id="cedula" required 
                                       class="form-input"
                                       placeholder="Número de cédula" value="{{ old('cedula') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                Tipo de Vinculación <span class="required">*</span>
                            </label>
                            <div class="select-container">
                                <i class="fas fa-briefcase select-icon"></i>
                                <select name="vinculacion" required class="form-select">
                                    <option value="">Seleccionar vinculación</option>
                                    <option value="contrato" {{ old('vinculacion') == 'contrato' ? 'selected' : '' }}>Contrato</option>
                                    <option value="funcionario_administrativo" {{ old('vinculacion') == 'funcionario_administrativo' ? 'selected' : '' }}>Funcionario Administrativo</option>
                                    <option value="provisional" {{ old('vinculacion') == 'provisional' ? 'selected' : '' }}>Provisional</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Estado y Acciones -->
                <div class="form-section">
                    <h3 class="form-section-title">
                        <i class="fas fa-cogs"></i>
                        Estado y Acciones
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label class="form-label">
                                Estado <span class="required">*</span>
                            </label>
                            <div class="select-container">
                                <i class="fas fa-check-circle select-icon"></i>
                                <select name="estado" required class="form-select">
                                    <option value="">Seleccionar estado</option>
                                    <option value="bueno" {{ old('estado') == 'bueno' ? 'selected' : '' }}>Bueno</option>
                                    <option value="regular" {{ old('estado') == 'regular' ? 'selected' : '' }}>Regular</option>
                                    <option value="malo" {{ old('estado') == 'malo' ? 'selected' : '' }}>Malo</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                Foto del Elemento
                            </label>
                            <div class="file-upload-container">
                                <i class="fas fa-camera file-upload-icon"></i>
                                <input type="file" name="foto" accept="image/*" class="form-file-input" id="foto">
                                <label for="foto" class="file-upload-label">
                                    <span class="file-upload-text">Seleccionar archivo</span>
                                    <span class="file-upload-hint">o arrastra aquí</span>
                                </label>
                            </div>
                            <p class="form-hint">Formatos permitidos: JPEG, PNG, JPG, GIF. Tamaño máximo: 2MB</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Acciones
                        </label>
                        <div class="textarea-container">
                            <i class="fas fa-tasks textarea-icon"></i>
                            <textarea name="acciones" rows="3"
                                      class="form-textarea"
                                      placeholder="Acciones realizadas o pendientes...">{{ old('acciones') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="form-actions">
                    <a href="{{ route('inventario.index') }}" class="modern-btn modern-btn-secondary">
                        <i class="fas fa-times"></i>
                        Cancelar
                    </a>
                    <button type="submit" class="modern-btn modern-btn-primary">
                        <i class="fas fa-save"></i>
                        Guardar Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Sincronización automática entre Nombre y Cédula
document.addEventListener('DOMContentLoaded', function() {
    const selectNombre = document.getElementById('nombre_responsable');
    const inputCedula = document.getElementById('cedula');
    
    // Datos de responsables
    const responsables = {
        'Carolina': '1234567890',
        'Maria': '0987654321',
        'Alcy': '1122334455',
        'Yoli': '5544332211'
    };
    
    // Cuando se selecciona un nombre, auto-completar la cédula
    selectNombre.addEventListener('change', function() {
        const nombre = this.value;
        if (nombre && responsables[nombre]) {
            inputCedula.value = responsables[nombre];
        }
    });
    
    // Cuando se escribe una cédula, auto-seleccionar el nombre
    inputCedula.addEventListener('blur', function() {
        const cedula = this.value;
        for (const [nombre, cc] of Object.entries(responsables)) {
            if (cc === cedula) {
                selectNombre.value = nombre;
                break;
            }
        }
    });
});
</script>




<style>
/* Variables CSS */
:root {
    --primary-color: #3b82f6;
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
    --purple-color: #8b5cf6;
    --gray-50: #f9fafb;
    --gray-100: #f3f4f6;
    --gray-200: #e5e7eb;
    --gray-300: #d1d5db;
    --gray-400: #9ca3af;
    --gray-500: #6b7280;
    --gray-700: #374151;
    --gray-900: #111827;
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
    --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
}

/* Animaciones */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

@keyframes shimmer {
    0% {
        background-position: -200px 0;
    }
    100% {
        background-position: calc(200px + 100%) 0;
    }
}

/* Layout */
.max-w-6xl { max-width: 72rem; }
.mx-auto { margin-left: auto; margin-right: auto; }
.flex { display: flex; }
.justify-between { justify-content: space-between; }
.justify-end { justify-content: flex-end; }
.items-center { align-items: center; }
.space-x-4 > * + * { margin-left: 1rem; }
.space-y-6 > * + * { margin-top: 1.5rem; }
.grid { display: grid; }
.grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
.grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
.grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
.gap-6 { gap: 1.5rem; }
.mb-2 { margin-bottom: 0.5rem; }
.mb-4 { margin-bottom: 1rem; }
.mt-1 { margin-top: 0.25rem; }
.pt-6 { padding-top: 1.5rem; }
.px-3 { padding-left: 0.75rem; padding-right: 0.75rem; }
.py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
.block { display: block; }
.text-sm { font-size: 0.875rem; line-height: 1.25rem; }
.text-lg { font-size: 1.125rem; line-height: 1.75rem; }
.text-xl { font-size: 1.25rem; line-height: 1.75rem; }
.font-medium { font-weight: 500; }
.font-semibold { font-weight: 600; }
.text-gray-700 { color: var(--gray-700); }
.text-gray-900 { color: var(--gray-900); }
.text-gray-500 { color: var(--gray-500); }
.text-red-500 { color: var(--danger-color); }
.border { border-width: 1px; }
.border-t { border-top-width: 1px; }
.border-gray-300 { border-color: var(--gray-300); }
.rounded-md { border-radius: 0.375rem; }
.w-full { width: 100%; }
.focus\:outline-none:focus { outline: 2px solid transparent; outline-offset: 2px; }
.focus\:ring-2:focus { --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color); --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color); box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000); }
.focus\:ring-blue-500:focus { --tw-ring-color: #3b82f6; }

/* Modern Form Container */
.modern-form-container {
    animation: fadeInUp 0.6s ease-out;
}

.modern-form-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border-radius: 20px;
    box-shadow: var(--shadow-xl);
    border: 1px solid var(--gray-200);
    overflow: hidden;
}

.modern-form-header {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    border-bottom: 1px solid var(--gray-200);
    padding: 2rem;
}

.modern-form {
    padding: 2rem;
}

/* Form Sections */
.form-section {
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: linear-gradient(135deg, #ffffff, #f8fafc);
    border-radius: 16px;
    border: 1px solid var(--gray-200);
    box-shadow: var(--shadow-sm);
    transition: all 0.3s ease;
    animation: slideInRight 0.8s ease-out;
}

.form-section:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-2px);
}

.form-section-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--gray-900);
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid var(--gray-200);
}

.form-section-title i {
    color: var(--primary-color);
    font-size: 1.5rem;
}

/* Form Groups */
.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--gray-700);
    margin-bottom: 0.5rem;
}

.required {
    color: var(--danger-color);
    font-weight: 600;
}

/* Input Containers */
.input-container,
.textarea-container,
.select-container {
    position: relative;
    display: flex;
    align-items: center;
}

.input-icon,
.textarea-icon,
.select-icon {
    position: absolute;
    left: 1rem;
    color: var(--gray-400);
    z-index: 1;
    transition: color 0.3s ease;
    font-size: 1rem;
}

.textarea-icon {
    top: 1rem;
    align-self: flex-start;
}

/* Form Inputs */
.form-input,
.form-textarea,
.form-select {
    width: 100%;
    padding: 0.875rem 1rem 0.875rem 2.5rem;
    border: 2px solid var(--gray-200);
    border-radius: 12px;
    background: white;
    font-size: 0.875rem;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-sm);
}

.form-textarea {
    padding-top: 1rem;
    resize: vertical;
    min-height: 100px;
}

.form-input:focus,
.form-textarea:focus,
.form-select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    transform: translateY(-1px);
}

.form-input:focus + .input-icon,
.form-textarea:focus + .textarea-icon,
.form-select:focus + .select-icon {
    color: var(--primary-color);
}

/* File Upload */
.file-upload-container {
    position: relative;
    border: 2px dashed var(--gray-300);
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    transition: all 0.3s ease;
    cursor: pointer;
}

.file-upload-container:hover {
    border-color: var(--primary-color);
    background: linear-gradient(135deg, #eff6ff, #dbeafe);
}

.file-upload-icon {
    font-size: 2rem;
    color: var(--gray-400);
    margin-bottom: 0.5rem;
    transition: color 0.3s ease;
}

.file-upload-container:hover .file-upload-icon {
    color: var(--primary-color);
}

.form-file-input {
    position: absolute;
    opacity: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
}

.file-upload-label {
    display: flex;
    flex-direction: column;
    align-items: center;
    cursor: pointer;
}

.file-upload-text {
    font-weight: 500;
    color: var(--gray-700);
    margin-bottom: 0.25rem;
}

.file-upload-hint {
    font-size: 0.75rem;
    color: var(--gray-500);
}

.form-hint {
    font-size: 0.75rem;
    color: var(--gray-500);
    margin-top: 0.5rem;
}

/* Modern Buttons */
.modern-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.875rem 1.5rem;
    border-radius: 12px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    font-size: 0.875rem;
}

.modern-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s ease;
}

.modern-btn:hover::before {
    left: 100%;
}

.modern-btn-primary {
    background: linear-gradient(135deg, var(--primary-color), #60a5fa);
    color: white;
    box-shadow: var(--shadow-sm);
}

.modern-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.modern-btn-secondary {
    background: linear-gradient(135deg, var(--gray-500), #9ca3af);
    color: white;
    box-shadow: var(--shadow-sm);
}

.modern-btn-secondary:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

/* Form Actions */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    padding: 2rem;
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    border-top: 1px solid var(--gray-200);
    margin: 2rem -2rem -2rem -2rem;
}

/* Loading States */
.form-input:disabled,
.form-textarea:disabled,
.form-select:disabled {
    background: var(--gray-100);
    color: var(--gray-500);
    cursor: not-allowed;
}

/* Success States */
.form-input:valid:not(:placeholder-shown),
.form-textarea:valid:not(:placeholder-shown),
.form-select:valid {
    border-color: var(--success-color);
}

.form-input:valid:not(:placeholder-shown) + .input-icon,
.form-textarea:valid:not(:placeholder-shown) + .textarea-icon,
.form-select:valid + .select-icon {
    color: var(--success-color);
}

/* Error States */
.form-input:invalid:not(:placeholder-shown),
.form-textarea:invalid:not(:placeholder-shown),
.form-select:invalid {
    border-color: var(--danger-color);
}

.form-input:invalid:not(:placeholder-shown) + .input-icon,
.form-textarea:invalid:not(:placeholder-shown) + .textarea-icon,
.form-select:invalid + .select-icon {
    color: var(--danger-color);
}

/* Responsive Design */
@media (min-width: 768px) {
    .md\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .md\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
}

@media (min-width: 1024px) {
    .lg\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
}

/* Scrollbar Styling */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: var(--gray-100);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, var(--primary-color), var(--success-color));
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #2563eb, #059669);
}
</style>

<script>
// Form interactions and animations
document.addEventListener('DOMContentLoaded', function() {
    // File upload preview
    const fileInput = document.getElementById('foto');
    const fileUploadContainer = document.querySelector('.file-upload-container');
    
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Update the upload container with file info
                    const uploadText = fileUploadContainer.querySelector('.file-upload-text');
                    const uploadHint = fileUploadContainer.querySelector('.file-upload-hint');
                    
                    uploadText.textContent = file.name;
                    uploadHint.textContent = `${(file.size / 1024 / 1024).toFixed(2)} MB`;
                    
                    // Add success styling
                    fileUploadContainer.style.borderColor = 'var(--success-color)';
                    fileUploadContainer.style.background = 'linear-gradient(135deg, #dcfce7, #bbf7d0)';
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Form validation feedback
    const inputs = document.querySelectorAll('.form-input, .form-textarea, .form-select');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.checkValidity()) {
                this.style.borderColor = 'var(--success-color)';
            } else {
                this.style.borderColor = 'var(--danger-color)';
            }
        });
        
        input.addEventListener('input', function() {
            if (this.checkValidity()) {
                this.style.borderColor = 'var(--success-color)';
            } else {
                this.style.borderColor = 'var(--gray-200)';
            }
        });
    });

    // Form submission animation
    const form = document.querySelector('.modern-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
            submitBtn.disabled = true;
            
            // Re-enable after 3 seconds (in case of errors)
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 3000);
        });
    }

    // Animate form sections on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'fadeInUp 0.6s ease-out';
            }
        });
    }, observerOptions);

    const formSections = document.querySelectorAll('.form-section');
    formSections.forEach(section => {
        observer.observe(section);
    });
});
</script>
@endsection