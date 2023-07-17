<?php

namespace App\Http\Controllers;

use App\Http\Requests\HandoverRequests\HandoverOffboardRequest;
use App\Http\Requests\HandoverRequests\HandoverOnboardRequest;
use App\Http\Requests\HandoverRequests\SelectOffboardingRequest;
use App\Models\Device;
use App\Models\Handover;
use App\Models\Location;
use App\Models\Status;
use App\Services\HandoverService;
use App\Services\PdfService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HandoverController extends Controller
{
    private PdfService $pdfService;
    private HandoverService $handoverService;

    public function __construct(PdfService $pdfService, HandoverService $handoverService){
        $this->pdfService = $pdfService;
        $this->handoverService = $handoverService;
    }

    /**
     * Display a listing of the resource.
     *
     * return \Illuminate\Http\Response
     */
    public function index(){
        $handovers = Handover::DisplayHandovers(null, false)
            ->orderBy('handovers.updated_at','desc')
            ->paginate(30)
            ->withQueryString();

        return view('handovers.index', compact('handovers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * return \Illuminate\Http\Response
     */
    public function create(){
        $locations = Location::all();
        return view('handovers.create', compact(['locations']));
    }

    /**
     * Store a newly created resource in storage.
     * onboarding
     * @param  \Illuminate\Http\Request  $request
     * return \Illuminate\Http\Response
     */
    public function store(HandoverOnboardRequest $request){
        $this->handoverService->store($request);
        return redirect()->route('handovers.index')->with('success', 'The Device/s were assgined succesfully');
    }

    public function getActiveHandovers(){
        $handovers =  Handover::DisplayHandovers(null, true)
                        ->orderBy('handovers.updated_at','desc')
                        ->paginate(30)
                        ->withQueryString();
        return view('handovers.selectOffboarding', compact('handovers'));
    }



    public function selectOffboarding(SelectOffboardingRequest $request){
        $selectedHandovers = $request->input('selectedHandovers');
        $handovers = Handover::whereIn('id', $selectedHandovers)->get();
        $availableStates = Status::statesForOffboarding()->get();
        return view('handovers.selectedReturns', compact(['handovers','availableStates']));
    }

    public function getPendingOffboardings(){

        $handovers =  Handover::DisplayHandovers('offboarding', true)
            ->orderBy('handovers.updated_at','desc')
            ->paginate(30);

        return view('handovers.PendingOffboardings',compact('handovers'));
    }


    public function updateOffboardingData(HandoverOffboardRequest $request){
        $this->handoverService->updateOffboardingData($request);
        return redirect()->route('activeHandovers')->with('success', 'The devices were successfully returned or moved to the offboarding');
    }


    public function onBoarding(HandoverOnboardRequest $request)
    {
        if ($request->input('action') === 'pdf') {
            // Generate PDF using the PdfController
            return $this->pdfService->OnboardingGeneratePDF($request);
        } elseif ($request->input('action') === 'store') {
            // Store data in database using the DataController
            return $this->store($request);
        }
    }


    public function offboardingOrPdf(HandoverOffboardRequest $request){
        if ($request->input('action') === 'pdf') {
            // Generate PDF using the PdfController
            return $this->pdfService->OffboardingGeneratePDF($request);
        } elseif ($request->input('action') === 'confirm') {
            // Store data in database using the DataController
            return $this->updateOffboardingData($request);
        }
    }

    public function handoversPendingSearch(Request $request){
        if(!$request->filled('q'))
            return back();

        $handovers = Handover::searchHandovers($request->input('q'), 'offboarding', true)
            ->orderBy('handovers.updated_at','desc')
            ->paginate(30)
            ->withQueryString();

        return view('handovers.PendingOffboardings', compact('handovers'));
    }

    public function activeHandoversSearch(Request $request){
        if(!$request->filled('q'))
            return back();

        $handovers = Handover::searchHandovers($request->input('q'), null, true)
            ->orderBy('handovers.updated_at','desc')
            ->paginate(30)
            ->withQueryString();

        return view('handovers.selectOffboarding', compact('handovers'));
    }

    public function allHandoversSearch(Request $request){
        if(!$request->filled('q'))
            return back();

        $handovers = Handover::searchHandovers($request->input('q'))
            ->orderBy('handovers.updated_at','desc')
            ->paginate(30)
            ->withQueryString();

        return view('handovers.index', compact('handovers'));
    }
}
