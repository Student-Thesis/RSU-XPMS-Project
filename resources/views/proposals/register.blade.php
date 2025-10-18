<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Proposal Submission - Stylique</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f44336, #2196f3, #4caf50, #ffeb3b);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .card {
            background-color: #ffffffcc;
            border-radius: 1rem;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            padding: 1.5rem;
        }

        .auth-btn {
            background: linear-gradient(to right, #f44336, #2196f3, #4caf50, #ffeb3b);
            background-size: 200%;
            color: #fff;
            border: none;
            transition: background-position 0.3s ease;
            text-align: center;
            display: block;
        }

        .auth-btn:hover {
            background-position: right center;
            color: #fff;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #4caf50;
            box-shadow: 0 0 0 0.25rem rgba(76, 175, 80, 0.25);
        }

        .form-section-title {
            font-weight: 600;
            margin-top: 25px;
            margin-bottom: 10px;
            color: #333;
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card">
                    <h4 class="text-center mb-4">Proposal Submission Form</h4>

                    <form method="POST" action="{{ route('proposals.store') }}">
                        @csrf

                        {{-- Title --}}
                        <div class="mb-2">
                            <label class="form-label">Title for Proposal</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}"
                                placeholder="Enter proposal title" required>
                        </div>

                        {{-- Classification (names, not slugs) --}}
                        <div class="mb-2">
                            <label class="form-label">Classification</label>
                            <select name="classification" class="form-select" required>
                                <option value="" disabled {{ old('classification') ? '' : 'selected' }}>
                                    Choose classification
                                </option>
                                <option value="Project" {{ old('classification') === 'Project' ? 'selected' : '' }}>
                                    Project</option>
                                <option value="Program" {{ old('classification') === 'Program' ? 'selected' : '' }}>
                                    Program</option>
                            </select>
                        </div>

                        {{-- Team Members --}}
                        <div class="mb-2">
                            <label class="form-label">Team Member Name(s)</label>
                            <input type="text" name="team_members" class="form-control"
                                value="{{ old('team_members') }}" placeholder="Separate multiple names with commas">
                        </div>

                        {{-- Target Agenda (names, not slugs) --}}
                        <div class="mb-2">
                            <label class="form-label">Target Agenda</label>
                            <select name="target_agenda" class="form-select">
                                <option value="" disabled {{ old('target_agenda') ? '' : 'selected' }}>
                                    Choose target agenda
                                </option>
                                @foreach ($targetAgendas as $agenda)
                                    <option value="{{ $agenda->name }}"
                                        {{ old('target_agenda') === $agenda->name ? 'selected' : '' }}>
                                        {{ $agenda->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Location --}}
                        <div class="mb-2">
                            <label class="form-label">Location</label>
                            <input type="text" name="location" class="form-control" value="{{ old('location') }}"
                                placeholder="Enter location">
                        </div>

                        {{-- Time Frame (string per validator) --}}
                        <div class="mb-2">
                            <label class="form-label">Required Time Frame</label>
                            <input type="date" name="time_frame" class="form-control"
                                value="{{ old('time_frame') }}" placeholder="e.g. 1 month or Oct–Dec 2025">
                        </div>

                        {{-- Target Beneficiaries --}}
                        <div class="form-section-title">Target Beneficiaries</div>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label">Who?</label>
                                <input type="text" name="beneficiaries_who" class="form-control"
                                    value="{{ old('beneficiaries_who') }}" placeholder="e.g. Farmers, Students">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">How many?</label>
                                <input type="number" name="beneficiaries_how_many" class="form-control"
                                    value="{{ old('beneficiaries_how_many') }}" placeholder="e.g. 100" min="0">
                            </div>
                        </div>

                        {{-- Budget --}}
                        <div class="form-section-title">Budget Requirements</div>
                        <div class="row g-2">
                            <div class="col-md-4">
                                <label class="form-label">PS</label>
                                <input type="text" name="budget_ps" class="form-control"
                                    value="{{ old('budget_ps') }}" placeholder="Enter PS">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">MOOE</label>
                                <input type="text" name="budget_mooe" class="form-control"
                                    value="{{ old('budget_mooe') }}" placeholder="Enter MOOE">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">CO</label>
                                <input type="text" name="budget_co" class="form-control"
                                    value="{{ old('budget_co') }}" placeholder="Enter CO">
                            </div>
                        </div>

                        {{-- Partner --}}
                        <div class="mt-3 mb-2">
                            <label class="form-label">Partner (if any)</label>
                            <input type="text" name="partner" class="form-control" value="{{ old('partner') }}"
                                placeholder="e.g. LGU, DepEd">
                        </div>

                        <div class="d-grid mt-3">
                            <button type="submit" class="btn btn-primary">Submit Proposal</button>
                        </div>
                    </form>



                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
