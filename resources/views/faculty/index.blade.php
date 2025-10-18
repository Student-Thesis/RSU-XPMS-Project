@extends('layouts.app')

@section('content')
    <div id="content">
        @include('layouts.partials.topnav')

        <!-- Main Content -->
        <div class="midde_cont">
            <div class="container-fluid">
                <div class="row column_title">
                    <div class="col-md-12">
                        <div class="page_title">
                            <h3>EXTENSION PERFORMANCE INDICATORS AND TARGETS</h3>
                        </div>
                    </div>
                </div>

                <!-- Filters + Search -->
                <div class="row">
                    <div class="col-md-4">
                        <label><strong>Search:</strong></label>
                        <input type="text" id="searchInput" class="form-control" placeholder="Search anything..."
                            onkeyup="filterTable()">
                    </div>
                    <div class="col-md-4">
                        <label><strong>Filter by College/Campus:</strong></label>
                        <select id="collegeFilter" class="form-control" onchange="filterTable()">
                            <option value="All">All</option>
                            <option value="CAS">CAS</option>
                            <option value="CBA">CBA</option>
                            <option value="CET">CET</option>
                            <option value="CAFES">CAFES</option>
                            <option value="CCMADI">CCMADI</option>
                            <option value="CED">CED</option>
                            <option value="GEPS">GEPS</option>
                            <option value="CALATRAVA CAMPUS">CALATRAVA CAMPUS</option>
                            <option value="STA. MARIA CAMPUS">STA. MARIA CAMPUS</option>
                            <option value="SANTA FE CAMPUS">SANTA FE CAMPUS</option>
                            <option value="SAN ANDRES CAMPUS">SAN ANDRES CAMPUS</option>
                            <option value="SAN AGUSTIN CAMPUS">SAN AGUSTIN CAMPUS</option>
                            <option value="ROMBLON CAMPUS">ROMBLON CAMPUS</option>
                            <option value="CAJIDIOCAN CAMPUS">CAJIDIOCAN CAMPUS</option>
                            <option value="SAN FERNANDO CAMPUS">SAN FERNANDO CAMPUS</option>
                        </select>
                    </div>

                    <div class="table-responsive" style="margin-top: 20px;">
                        <table id="proposalTable" class="table table-bordered table-striped text-center align-middle">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No.</th>
                                    <th>Campus/College</th>
                                    <th>No. Of Regular Faculties</th>
                                    <th>No. Of Involved in Extension (60% - 173)</th>
                                    <th>Q1</th>
                                    <th>Q2</th>
                                    <th>Q3</th>
                                    <th>Q4</th>
                                    <th>No. Of IEC Materials Developed (25)</th>
                                    <th>Q1</th>
                                    <th>Q2</th>
                                    <th>Q3</th>
                                    <th>Q4</th>
                                    <th>No. Of IEC Materials Reproduced (600)</th>
                                    <th>Q1</th>
                                    <th>Q2</th>
                                    <th>Q3</th>
                                    <th>Q4</th>
                                    <th>No. OF IEC Materials Distrubuted (600)</th>
                                    <th>Q1</th>
                                    <th>Q2</th>
                                    <th>Q3</th>
                                    <th>Q4</th>
                                    <th>No. Of Quility Extension Proposal Approved(13)</th>
                                    <th>Q1</th>
                                    <th>Q2</th>
                                    <th>Q3</th>
                                    <th>Q4</th>
                                    <th>No. Of Quality Extension Proposals Implemented (13)</th>
                                    <th>Q1</th>
                                    <th>Q2</th>
                                    <th>Q3</th>
                                    <th>Q4</th>
                                    <th>No. Of Quality Extension Proposals Documented (13)</th>
                                    <th>Q1</th>
                                    <th>Q2</th>
                                    <th>Q3</th>
                                    <th>Q4</th>
                                    <th>No. Of Community Population Served (5,939)</th>
                                    <th>Q1</th>
                                    <th>Q2</th>
                                    <th>Q3</th>
                                    <th>Q4</th>
                                    <th>No. Of Benefiaries Of Technical Assistance (813)</th>
                                    <th>Q1</th>
                                    <th>Q2</th>
                                    <th>Q3</th>
                                    <th>Q4</th>
                                    <th>No. Of MOA/MOU Signed (8)</th>
                                    <th>Q1</th>
                                    <th>Q2</th>
                                    <th>Q3</th>
                                    <th>Q4</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>CCMADI</td>
                                    <td>17</td>
                                    <td>2</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>

                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
