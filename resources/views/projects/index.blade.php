@extends('layouts.app')

@section('content')
 <div id="content">
        <!-- Topbar -->
        <div class="topbar">
          <nav class="navbar navbar-expand-lg navbar-light">
            <div class="full">
              <button type="button" id="sidebarCollapse" class="sidebar_toggle"><i class="fa fa-bars"></i></button>
              <div class="logo_section">
                <a href="index.html"><img class="img-responsive" src="images/logo/logo.png" alt="#" /></a>
              </div>
              <div class="right_topbar">
                <div class="icon_info">
                  <ul>
                    <li><a href="#"><i class="fa fa-bell-o"></i><span class="badge">2</span></a></li>
                    <li><a href="#"><i class="fa fa-question-circle"></i></a></li>
                    <li><a href="#"><i class="fa fa-envelope-o"></i><span class="badge">3</span></a></li>
                  </ul>
                  <ul class="user_profile_dd">
                    <li>
                      <a class="dropdown-toggle" data-toggle="dropdown"><img class="img-responsive rounded-circle" src="images/layout_img/user_img.jpg" alt="#" /><span class="name_user">John David</span></a>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="profile.html">My Profile</a>
                        <a class="dropdown-item" href="settings.html">Settings</a>
                        <a class="dropdown-item" href="help.html">Help</a>
                        <a class="dropdown-item" href="#"><span>Log Out</span> <i class="fa fa-sign-out"></i></a>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </nav>
        </div>
        <!-- End Topbar -->

        <!-- Main Content -->
        <div class="midde_cont">
          <div class="container-fluid">
            <div class="row column_title">
              <div class="col-md-12">
                <div class="page_title">
                  <h3>2025 Extension Project Proposals</h3>
                </div>
              </div>
            </div>

            <!-- Filters + Search -->
            <div class="row">
              <div class="col-md-4">
                <label><strong>Search:</strong></label>
                <input type="text" id="searchInput" class="form-control" placeholder="Search anything..." onkeyup="filterTable()">
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
              <div class="col-md-4">
                <label><strong>Filter by Status:</strong></label>
                <select id="statusFilter" class="form-control" onchange="filterTable()">
                  <option value="All">All</option>
                  <option value="Ongoing">Ongoing</option>
                  <option value="Completed">Completed</option>
                  <option value="Cancelled">Cancelled</option>
                </select>
              </div>
            </div>

            <div class="table-responsive" style="margin-top: 20px;">
              <table id="proposalTable" class="table table-bordered table-striped text-center align-middle">
                <thead class="thead-dark">
                  <tr>
                    <th>No.</th>
                    <th>Title</th>
                    <th>Classification</th>
                    <th>Program/Project Leader</th>
                    <th>Team Members</th>
                    <th>College/Campus</th>
                    <th>Target Agenda</th>
                    <th>In-House</th>
                    <th>Revised Proposal</th>
                    <th>NTP</th>
                    <th>Endorsement</th>
                    <th>Proposal Presentation</th>
                    <th>Proposal Documents</th>
                    <th>Program Proposal</th>
                    <th>Project Proposal</th>
                    <th>MOA/MOU</th>
                    <th>Activity Design</th>
                    <th>Certificate of Appearance</th>
                    <th>Attendance Sheet</th>
                    <th>Photos</th>
                    <th>Terminal Report</th>
                    <th>Approved Budget</th>
                    <th>Source of Funds</th>
                    <th>Expenditure</th>
                    <th>Fund Utilization Rate</th>
                    <th>Partner</th>
                    <th>Status</th>
                    <th>Documentation Report</th>
                    <th>Code</th>
                    <th>Remarks</th>
                    <th>Drive Link</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Sample Project Title</td>
                    <td>
  <input list="classification-list" class="form-control" value="Project" style="min-width:110px;max-width:140px;display:inline-block;" />
  <datalist id="classification-list">
    <option value="Program">
    <option value="Project">
  </datalist>
</td>
                    <td>Jane Doe</td>
                    <td>Member A, Member B</td>
                    <td>Romblon Campus</td>
                    <td class="agenda-education">Education</td>
                    <!-- Dropdowns -->
                    <td><select class="dropdown-yesno yes" onchange="updateDropdownColor(this)"><option selected>Yes</option><option>No</option></select></td>
                    <td><select class="dropdown-yesno yes" onchange="updateDropdownColor(this)"><option selected>Yes</option><option>No</option></select></td>
                    <td><select class="dropdown-yesno yes" onchange="updateDropdownColor(this)"><option selected>Yes</option><option>No</option></select></td>
                    <td><select class="dropdown-yesno yes" onchange="updateDropdownColor(this)"><option selected>Yes</option><option>No</option></select></td>
                    <td><select class="dropdown-yesno yes" onchange="updateDropdownColor(this)"><option selected>Yes</option><option>No</option></select></td>
                    <td><select class="dropdown-yesno yes" onchange="updateDropdownColor(this)"><option selected>Yes</option><option>No</option></select></td>
                    <td><select class="dropdown-yesno yes" onchange="updateDropdownColor(this)"><option selected>Yes</option><option>No</option></select></td>
                    <td><select class="dropdown-yesno yes" onchange="updateDropdownColor(this)"><option selected>Yes</option><option>No</option></select></td>
                    <td><select class="dropdown-yesno yes" onchange="updateDropdownColor(this)"><option selected>Yes</option><option>No</option></select></td>
                    <td><select class="dropdown-yesno yes" onchange="updateDropdownColor(this)"><option selected>Yes</option><option>No</option></select></td>
                    <td><select class="dropdown-yesno yes" onchange="updateDropdownColor(this)"><option selected>Yes</option><option>No</option></select></td>
                    <td><select class="dropdown-yesno yes" onchange="updateDropdownColor(this)"><option selected>Yes</option><option>No</option></select></td>
                    <td><select class="dropdown-yesno yes" onchange="updateDropdownColor(this)"><option selected>Yes</option><option>No</option></select></td>
                    <td><select class="dropdown-yesno yes" onchange="updateDropdownColor(this)"><option selected>Yes</option><option>No</option></select></td>
                    
                    <!-- Editable Budget -->
                    <td contenteditable="true">29325</td>

                    <td>101</td>
                    <td></td>
                    <td>80%</td>
                    <td>External Donor</td>
                    <td class="status-ongoing">Ongoing</td>
                    <td>Available</td>
                    <td>2025-01</td>
                    <td>No remarks</td>
                    <td><a href="#">View Drive</a></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
@endsection