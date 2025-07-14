<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithEvents, WithHeadingRow
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Student::query()
            ->with(['grade', 'guardian.address', 'classrooms', 'videoCourses'])
            ->select('students.*');

        if ($this->request->filled('grade_id')) {
            $query->where('grade_id', $this->request->grade_id);
        }

        if ($this->request->filled('classroom_id')) {
            $query->whereHas('classrooms', function ($q) {
                $q->where('classroom_id', $this->request->classroom_id);
            });
        }

        if ($this->request->filled('status')) {
            $query->where('status', $this->request->status);
        }

        if ($this->request->filled('period')) {
            [$start, $end] = explode(' - ', $this->request->period);
            $query->whereBetween('created_at', [Carbon::createFromFormat('d/m/Y', $start), Carbon::createFromFormat('d/m/Y', $end)]);
        }

        return $query;
    }

    public function map($student): array
    {
        $province = $student->guardian?->address?->first()?->province ?? 'N/A';

        $courses = $student->videoCourses?->pluck('title')->join(', ') ?? 'N/A';

        $guardianAddress = $student->guardian?->fullAddress ?? 'N/A';

        $guardianName = $student->guardian?->name;
        $guardianCompany = $student->guardian?->work_company;

        return [
            $student->full_name,
            $guardianName ? ($guardianCompany ? "$guardianName - $guardianCompany" : $guardianName) : 'N/A',
            $student->grade?->name ?? '',
            $student->classrooms?->pluck('name')->join(', ') ?? '',
            $courses,
            $province,
            $guardianAddress,
            $student->status == 1 ? 'Ativo' : 'Inativo',
            $student->guardian?->phone_number ?? 'N/A',
            $student->email ?? 'N/A',
            $student->notes ?? '',
        ];
    }

    public function headings(): array
    {
        return [
            'Nome',
            'Nome do Responsável',
            'Série',
            'Turma',
            'Cursos',
            'Província',
            'Endereço',
            'Status',
            'Nº Telefone',
            'E-mail',
            'Observações',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:K1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '46BDC6',
                ],
            ]
        ]);

        $sheet->getRowDimension(1)->setRowHeight(25);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->insertNewRowBefore(1, 1);
                $sheet->mergeCells('A1:C1');

                $sheet->getRowDimension(1)->setRowHeight(55);

                $drawing = new Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('Melis Education Logo');
                $drawing->setPath(public_path('images/melis-education-horizontal.png'));
                $drawing->setHeight(50);
                $drawing->setCoordinates('A1');
                $drawing->setOffsetX(15);
                $drawing->setOffsetY(10);
                $drawing->setWorksheet($sheet);

                $highestRow = $sheet->getHighestRow();
                for ($row = 2; $row <= $highestRow; $row++) {
                    $sheet->getRowDimension($row)->setRowHeight(25);
                }

                $sheet->getColumnDimension('A')->setWidth(30.6);
                $sheet->getColumnDimension('B')->setWidth(30.6);
                $sheet->getColumnDimension('C')->setWidth(40.0);
                $sheet->getColumnDimension('D')->setWidth(50);
                $sheet->getColumnDimension('E')->setWidth(60);
                $sheet->getColumnDimension('F')->setWidth(21.1);
                $sheet->getColumnDimension('G')->setWidth(60);
                $sheet->getColumnDimension('H')->setWidth(18.6);
                $sheet->getColumnDimension('I')->setWidth(25.1);
                $sheet->getColumnDimension('J')->setWidth(40.7);
                $sheet->getColumnDimension('K')->setWidth(60);
            },
        ];
    }
}
