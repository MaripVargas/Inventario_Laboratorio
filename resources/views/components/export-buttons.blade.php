@php
$pdfRoute = $pdfRoute ?? '';
$excelRoute = $excelRoute ?? '';
$showPdf = $showPdf ?? true;
$showExcel = $showExcel ?? true;
$class = $class ?? '';
$modulo = $modulo ?? '';
@endphp


<div class="export-buttons-container {{ $class }}">
    <div class="export-buttons-grid">
        @if($showPdf && $pdfRoute)
            <a href="{{ route($pdfRoute, $modulo) }}" class="export-btn export-btn-pdf" download>
                <div class="export-icon">
                    <i class="fas fa-file-pdf"></i>
                </div>
                <div class="export-content">
                    <h3 class="export-title">Exportar PDF</h3>
                    <p class="export-subtitle">Descargar en PDF</p>
                </div>
                <div class="export-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
        @endif

        @if($showExcel && $excelRoute)
            <a href="{{ route($excelRoute, $modulo) }}" class="export-btn export-btn-excel" download>
                <div class="export-icon">
                    <i class="fas fa-file-excel"></i>
                </div>
                <div class="export-content">
                    <h3 class="export-title">Exportar Excel</h3>
                    <p class="export-subtitle">Descargar en Excel</p>
                </div>
                <div class="export-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
        @endif
    </div>
</div>

<style>
.export-buttons-container {
    margin: 2rem 0;
}

.export-buttons-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
}

.export-btn {
    display: flex;
    align-items: center;
    gap: 1.25rem;
    padding: 1.5rem;
    border-radius: 12px;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 2px solid transparent;
    background-color: #f8f9fa;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.export-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s ease;
}

.export-btn:hover::before {
    left: 100%;
}

.export-btn:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
}

.export-btn-pdf {
    border-color: #fbbf24;
}

.export-btn-pdf:hover {
    background-color: #fffbeb;
    border-color: #f59e0b;
}

.export-btn-excel {
    border-color: #86efac;
}

.export-btn-excel:hover {
    background-color: #f0fdf4;
    border-color: #22c55e;
}

.export-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 56px;
    height: 56px;
    border-radius: 10px;
    font-size: 1.75rem;
    flex-shrink: 0;
}

.export-btn-pdf .export-icon {
    background-color: #fef3c7;
    color: #d97706;
}

.export-btn-excel .export-icon {
    background-color: #dcfce7;
    color: #16a34a;
}

.export-content {
    flex: 1;
    min-width: 0;
}

.export-title {
    margin: 0;
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
}

.export-subtitle {
    margin: 0.25rem 0 0 0;
    font-size: 0.875rem;
    color: #6b7280;
}

.export-arrow {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: #9ca3af;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.export-btn:hover .export-arrow {
    color: #374151;
    transform: translateX(4px);
}

@media (max-width: 640px) {
    .export-buttons-grid {
        grid-template-columns: 1fr;
    }

    .export-btn {
        gap: 1rem;
        padding: 1.25rem;
    }

    .export-icon {
        width: 48px;
        height: 48px;
        font-size: 1.5rem;
    }

    .export-title {
        font-size: 1rem;
    }
}
</style>