<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.Head')
    <title>Asset Management</title>
    <script src ="{{ asset('bootstrap-5.0.2/js/typahead.js') }}" rel="stylesheet"></script>

    <style>
        .dropdown-item{
            background-color: transparent;
        }
        .searchForm { display: flex; }

        #dropdown-content { position: absolute;
            background-color: #f6f6f6; width: 230px;
            overflow: auto; z-index: 100;
        }

        #dropdown-content div {
            color: black;
            padding: 12px 16px;
            cursor: pointer;
        }

        .dropdown div:hover {
            background-color: #ddd;
        }

    </style>


</head>
<body class="d-flex flex-column min-vh-100" id="onboarding-body" onload="initializeTypeahead()">
@include('layouts.Nav')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<div class="container">

    <div class="container border border-5" style="max-width: 900px; margin-bottom: 40px;" id="onboarding-form-box">
    <div class="row justify-content-center">
        <div class="col-md-6" style="width: 420px;">
            <h4 style="text-align: center">Onboarding</h4>
        </div>
    </div>

        <form method="POST" action=" {{ route('handovers.onboarding') }}" autocomplete="off" id="onboardForm">
        <div class="row justify-content-center" id="onboarding-form">
            <div class="col-md-6" style="width: 420px">
                @csrf

                <div class="row mb-3">
                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">
                        <a href="{{ route('employees.index') }}#staticBackdrop" style="text-decoration: none; color: black;">
                        Employee <img src="{{ asset('images/order_icon.png') }}" id="order-icon">
                    </a></label>
                    <div class="col-sm-8">
                        <input type="hidden" id="employeeId" value="{{ old('employeeId') }}" name="employeeId">
                        <input type="text" placeholder="Search..." id="myInput" name="myInput"  value="{{ old('myInput') }}" class="form-control form-control-sm" />
                        <div id="dropdown-content"></div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">
                            Personal Num
                        </label>
                    <div class="col-sm-8">
                        <input type="text" readonly id="personal_number" value="{{ old('personal_number') }}" name="personal_number" class="form-control form-control-sm" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">
                        Location
                    </label>
                    <div class="col-sm-8">
                        <input type="text" readonly id="location" name="location" value="{{ old('location') }}" class="form-control form-control-sm" />
                    </div>
                </div>


                <div class="row mb-3">
                    <label for="colFormLabelSm" class="col-sm-8 col-form-label col-form-label-sm">Does the Employee get Keys</label>
                        <div class="col-sm-4">
                            <input class="form-check-input" type="checkbox" name="key" id="flexCheckDefault">
                        </div>
                </div>

                </div>
                <div class="col-md-6" style="width: 420px">
                    <button class="btn" id="add-input-button" type="button">+</button>
                    <button class="btn" type="button" id="remove-input-button">-</button>
                        <div class="row mb-3" id="input-container">
                                @if (old('devices'))
                                    @for( $i = 0; $i < count(old('devices')); $i++)
                                        @if(old('devices.'.$i) != null)
                                        <div class="row mb-3">
                                            <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Device</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="devices[]" id="device{{ $i }}" value="{{ old('devices.'.$i) }}" autocomplete ="off" class="form-control form-control-sm typeahead" placeholder="MOB-XXXX">
                                                </div>
                                        </div>
                                        @endif
                                    @endfor
                                @else
                                        <div class="row mb-3">
                                            <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Device</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="devices[]" id="device0" value="{{ old('devices.0') }}" autocomplete ="off" class="form-control form-control-sm typeahead" placeholder="MOB-XXXX">
                                                </div>
                                        </div>
                                @endif
                        </div>
                </div>
                <div class="col-md-6" style="width: 450px">
                <div class="d-flex justify-content-center" style="column-gap:0.5rem">

                        <button class="btn btn-danger" type="submit" name="action" value="pdf" id="pdfButton" formtarget="_blank">Generate PDF</button>
                        <button class="btn btn-danger" type="submit" name="action" value="store" id="submitBtn">Store Data</button>
                        <button class="btn btn-danger" type="reset" onclick="window.location.reload()">Reset Input</button>

                </div>
                </div>
        </div>
    </form>



    </div>
</div>

@include('layouts.Footer')
</body>

<script>
    let names = []; // Server response (JSON Array)
    let fetched = false; // State // Less than 3 characters: Cleanup (user has deleted the search field or has less than 3 characters to search with)
    document.getElementById('myInput').addEventListener("keyup", async (e) => {
        const src = e.target; // Searchbar (#myInput)
        const idElement = document.getElementById("employeeId"); // (Hidden) field to save the id for the next request.
        const searchName = (src.value || "").toLowerCase();
        const listContent = document.getElementById("dropdown-content"); // Empty div, filled by the response.

        if (searchName.length < 3) { fetched = false; listContent.innerHTML = ""; }
        // A search is made for 3 or more characters.
        // No or invalid data from server: we have to fetch data from the server.
        if (searchName.length >= 3 && !fetched) { // Important: Set the state first. If not, you will generate many search queries when a user types and the data is not yet loaded.
            fetched = true;

            try { // Customize the url.
                const response = await fetch(`/names?filter=${searchName}`);

                names = await response.json();
            }
            catch (e) { alert("Error fetching names from server"); }
        }
        // We have data: filter locally
        if (searchName.length >= 3 && fetched) {
            listContent.innerHTML = "";
            const filteredNames = names.filter(n => {
                const fullName = `${n.firstname} ${n.surname}`.toLowerCase();
                return fullName.includes(searchName);
            });
            for (const name of filteredNames) {
                const item = document.createElement("div");
                item.innerText = `${name.surname} ${name.firstname}`;
                // Add an event handler for the generated list item to set the form fields on click.
                item.addEventListener("click", (e) => {
                    src.value = `${name.surname} ${name.firstname}`;
                    idElement.value = name.id;
                    listContent.innerHTML = "";
                    document.getElementById("location").value = name.location_name;
                    document.getElementById("personal_number").value = name.personal_number;
                });
                listContent.append(item);
            }
        }
    });

    const MAX_FIELDS = 10; // Maximum number of fields allowed

    document.getElementById('add-input-button').addEventListener('click', function() {
        const inputContainer = document.getElementById('input-container');
        const inputCount = inputContainer.childElementCount + 1;

        // If the input count exceeds the maximum, do nothing
        if (inputCount > MAX_FIELDS) {
            return;
        }

        // Otherwise, create the new field
        const newInputContainer = document.createElement('div');
        const newColContainter = document.createElement('div');
        newColContainter.className = "col-sm-8";
        newInputContainer.className = "row mb-3";

        const newLabel = document.createElement('label');
        newLabel.htmlFor = 'colFormLabelSm';
        newLabel.className="col-sm-4 col-form-label col-form-label-sm";
        newLabel.innerHTML = "Device ";
        const newInput = document.createElement('input');
        newInput.type = 'text';
        newInput.className = 'typeahead form-control form-control-sm'
        newInput.name = `devices[]`;
        newInput.id = `device${inputCount}`;
        newInput.placeholder =`MOB-XXXX`;

        newColContainter.appendChild(newInput);
        newInputContainer.appendChild(newLabel);
        newInputContainer.appendChild(newColContainter);

        inputContainer.appendChild(newInputContainer);
        initializeTypeahead();
    });


    document.getElementById('remove-input-button').addEventListener('click', function() {
        const inputContainer = document.getElementById('input-container');
        if (inputContainer.childElementCount > 1) {
            inputContainer.removeChild(inputContainer.lastChild);
        }
    });
    document.getElementById("onboardForm").addEventListener("submit", function(e) {
        let deviceInputs = document.querySelectorAll("input[name='devices[]']");
        let filled = false;
        for (let i = 0; i < deviceInputs.length; i++) {
            if (deviceInputs[i].value !== "") {
                filled = true;
                break;
            }
        }
        if (!filled) {
            e.preventDefault();
            alert("At least one device field must be filled.");
        }
    });


    function initializeTypeahead() {
        var path = "{{ route('autocomplete') }}";
        $('input.typeahead').typeahead({
            source:  function (query, process) {
                return $.get(path, { query: query }, function (data) {
                    return process(data);
                });
            },
            minLength: 3
        });
    }
    initializeTypeahead();


</script>

</html>
