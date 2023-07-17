<?php
namespace App\Services;

use App\Http\Requests\HandoverRequests\HandoverOnboardRequest;
use App\Models\Device;
use App\Models\DeviceModel;
use App\Models\Employee;
use App\Models\Handover;
use App\Models\Status;
use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;

class PdfService {

    public function OffboardingGeneratePDF(Request $request)
    {
        $handovers = collect($request->input('handoversid'));
        $pdf = new Fpdi();

        $pdf->setSourceFile(base_path() . '/public/Forms/Returnform.pdf');
        $pdf->AddPage();
        $templateId = $pdf->importPage(1);
        $pdf->useTemplate($templateId, ['adjustPageSize' => true]);

        $handover = Handover::with('employee')->where('id',$handovers[0])->first();

        $firstname = iconv('UTF-8', 'windows-1252', $handover->employee->firstname);
        $surname = iconv('UTF-8', 'windows-1252', $handover->employee->surname);
        $pdf->SetXY(40, 33);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(20, 5, $surname . ' ' . $firstname);


        $pdf->SetFont('Arial', '', 12);
        $pdf->setXY(145, 80);
        $pdf->Cell(40, 5, date('d.m.Y', strtotime(now())), '', '', 'L');



        $pdf->SetFont('Arial', '', '12');
        $y = 122;
        foreach ($handovers as $handover) {
            $data = Handover::with(['device.devicemodel'])->where('id',$handover)->first();

            $vendor = $data->device->devicemodel->vendor;
            $model = $data->device->devicemodel->model;

            $pdf->Ln();
            $pdf->setXY(30, $y);
            $pdf->Cell(120, 10, $vendor . ' ' . $model, 0);
            $pdf->Cell(50, 10, $data->device->inventory_id, 0);
            $y += 10;
        }

        $pdf->SetTitle($surname.'_ReturnForm_'.date('d/m/Y', strtotime(now())));
        $pdf->Output('',$surname.'_ReturnForm_'.date('d/m/Y', strtotime(now())).'.pdf');
        $pdf->close();
        return $pdf;
    }

    public function OnboardingGeneratePDF(HandoverOnboardRequest $request)
    {
        $employeeid = $request->input('employeeId');
        $devices = $request->input('devices');


        foreach ($devices as $device) {
            $deviceExist = Device::where('inventory_id', $device)->exists();
            if (!$deviceExist) {
                return redirect()->back()->with('error', 'The entered inventory number '. $device.' was not found. No device/s were assigned');
            }

            $deviceid = Device::where('inventory_id', $device)->value('id');
            $inStoreid = Status::where('status_name', 'in Store')->value('id');

            // Check if the device has the "in Store" status
            $checkDeviceStatus = Device::with('status')
                ->where('id', $deviceid)
                ->where('status_id', $inStoreid)
                ->first();
            if (!$checkDeviceStatus) {
                return redirect()->back()->with('error', 'The Device '. $device.' is already assigned or not available. No device/s were assigned');
            }
        }

        $firstnameRaw = Employee::where('id',$employeeid)->value('firstname');
        $surnameRaw = Employee::where('id',$employeeid)->value('surname');
        $firstname = iconv('UTF-8', 'windows-1252', $firstnameRaw);
        $surname = iconv('UTF-8', 'windows-1252', $surnameRaw);


        // initiate FPDI
        $pdf = new Fpdi();
        // get the page count

        $pageCount = $pdf->setSourceFile(base_path() . '/public/Forms/HandoverForm.pdf');
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $pdf->AddPage();
            $templateId = $pdf->importPage($pageNo);
            $pdf->useTemplate($templateId, ['adjustPageSize' => true]);


            if ($pageNo == 1) {
                $pdf->SetXY(40, 33);
                $pdf->SetFont('Arial', 'B', 14);
                $pdf->Cell(20, 5, $surname.' '.$firstname);


                $pdf->SetFont('Arial', '', 12);
                $pdf->setXY(145, 80);
                $pdf->Cell(40, 5, date('d.m.Y', strtotime(now())), '', '', 'L');


                $y=122;
                foreach ($devices as $device) {

                    $dm = Device::where('inventory_id',$device)->value('devicemodel_id');

                    $vendor = DeviceModel::where('id',$dm)->value('vendor');
                    $model = DeviceModel::where('id',$dm)->value('model');

                    $pdf->Ln();
                    $pdf->setXY(30, $y);
                    $pdf->Cell(120, 10, $vendor . ' ' . $model, 0);
                    $pdf->Cell(50, 10, $device, 0);
                    $y += 10;
                }
                if($request->key){
                    $pdf->setXY(30, $y);
                    $pdf->Cell(120, 10, 'Keys', 0);
                }

            }
        }

        $pdf->SetTitle($surname.'_HandoverForm_'.date('d/m/Y', strtotime(now())));
        $pdf->Output('',$surname.'_HandoverForm_'.date('d/m/Y', strtotime(now())).'.pdf');
        $pdf->close();
        return $pdf;
    }
}
