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

         <div class="midde_cont">
          <div class="container-fluid">
            <div class="row column_title">
              <div class="col-md-12">
                <div class="page_title">
                  <h2>List of Records / Forms</h2>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="white_shd full margin_bottom_30">
                  <div class="full">
                    <div class="table_section padding_infor_info">

                      <div class="mb-3">
                        <button class="btn btn-success" onclick="addRecord()">
                          <i class="fa fa-plus"></i> Add Record
                        </button>
                      </div>

                      <div class="table-responsive-sm">
                        <table class="table table-bordered">
                          <thead class="thead-dark">
                            <tr>
                              <th>No.</th>
                              <th>Record Code</th>
                              <th>Record Title (Link)</th>
                              <th>Maintenance Period</th>
                              <th>Preservation Period</th>
                              <th>Remarks</th>
                              <th>Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr><td>1</td><td>ECO-00-001</td><td><a href="https://docs.google.com/document/d/1ieQ26xU9W-hj0CJhqnOInG6VZtkTFDzm/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true" target="_blank" style="color:#007bff;">Faculty Extension Involvement</a></td>
                              <td>5 Years</td><td>5 Years</td><td>IN-USE</td>  
                              <td>
                                <button class="btn btn-sm btn-primary" onclick="editRecord(this)">
                                  <i class="fa fa-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteRecord(this)">
                                  <i class="fa fa-trash"></i>
                                </button>
                              </td>
                            </tr>
                            <tr><td>2</td><td>ECO-00-002</td><td><a href="https://docs.google.com/document/d/146Of7PklEiGJG3lkbqajLk-CmfMcan7G/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true" target="_blank" style="color:#007bff;">Summary of Faculty Extension Involvement</a></td> <td>5 Years</td><td>5 Years</td><td>IN-USE</td>  
                              <td>
                                <button class="btn btn-sm btn-primary" onclick="editRecord(this)">
                                  <i class="fa fa-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteRecord(this)">
                                  <i class="fa fa-trash"></i>
                                </button>
                              </td>
                            </tr>
                            <tr><td>3</td><td>ECO-00-003</td><td><a href="https://docs.google.com/document/d/1iovqO_RklBR9tfhel61taRxWpkosGeMm/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true" target="_blank" style="color:#007bff;">Technical Advice Slip</a></td>< <td>5 Years</td><td>5 Years</td><td>IN-USE</td>  
                              <td>
                                <button class="btn btn-sm btn-primary" onclick="editRecord(this)">
                                  <i class="fa fa-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteRecord(this)">
                                  <i class="fa fa-trash"></i>
                                </button>
                              </td>
                            </tr>
                            <tr><td>4</td><td>ECO-00-004</td><td><a href="https://docs.google.com/document/d/1nnMeyhI5KGMQj7msUgCREs5_-TXT3OMh/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true" target="_blank" style="color:#007bff;">Financial Report</a></td> <td>5 Years</td><td>5 Years</td><td>IN-USE</td>  
                              <td>
                                <button class="btn btn-sm btn-primary" onclick="editRecord(this)">
                                  <i class="fa fa-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteRecord(this)">
                                  <i class="fa fa-trash"></i>
                                </button>
                              </td>
                            </tr>
                            <tr><td>5</td><td>ECO-00-005</td><td><a href="https://docs.google.com/document/d/1Wn2Pa-BUdVMJ9mxiPa8AD5vYi4dCgCpx/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true" target="_blank" style="color:#007bff;">Training Needs Assessment (TNA)</a></td> <td>5 Years</td><td>5 Years</td><td>IN-USE</td>  
                              <td>
                                <button class="btn btn-sm btn-primary" onclick="editRecord(this)">
                                  <i class="fa fa-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteRecord(this)">
                                  <i class="fa fa-trash"></i>
                                </button>
                              </td>
                            </tr>
                            <tr><td>6</td><td>ECO-00-006</td><td><a href="https://docs.google.com/document/d/1KqRSMrFNlao8FTbjXCLBVWctdL1YysyU/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true" target="_blank" style="color:#007bff;">Extension Training Proposal</a></td> <td>5 Years</td><td>5 Years</td><td>IN-USE</td>  
                              <td>
                                <button class="btn btn-sm btn-primary" onclick="editRecord(this)">
                                  <i class="fa fa-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteRecord(this)">
                                  <i class="fa fa-trash"></i>
                                </button>
                              </td>
                            </tr>
                            <tr><td>7</td><td>ECO-00-007</td><td><a href="https://docs.google.com/document/d/19s8cIYPycKNauBYd9IY6ViOrwaQ7d92o/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true" target="_blank" style="color:#007bff;">Special Order Form</a></td> <td>5 Years</td><td>5 Years</td><td>IN-USE</td>  
                              <td>
                                <button class="btn btn-sm btn-primary" onclick="editRecord(this)">
                                  <i class="fa fa-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteRecord(this)">
                                  <i class="fa fa-trash"></i>
                                </button>
                              </td>
                            </tr>
                            <tr><td>8</td><td>ECO-00-008</td><td><a href="https://docs.google.com/document/d/1xzHbEaAZxDVeIt5iwbdmIZyXmo4kS8ns/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true" target="_blank" style="color:#007bff;">Extension Project Accomplishment Report</a></td> <td>5 Years</td><td>5 Years</td><td>IN-USE</td>  
                              <td>
                                <button class="btn btn-sm btn-primary" onclick="editRecord(this)">
                                  <i class="fa fa-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteRecord(this)">
                                  <i class="fa fa-trash"></i>
                                </button>
                              </td>
                            </tr>
                            <tr><td>9</td><td>ECO-00-009</td><td><a href="https://docs.google.com/document/d/19a0hYjsC4I32HY3fGwzs_vcTJLOGA51I/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true" target="_blank" style="color:#007bff;">Extension Project Monitoring Report</a></td> <td>5 Years</td><td>5 Years</td><td>IN-USE</td>  
                              <td>
                                <button class="btn btn-sm btn-primary" onclick="editRecord(this)">
                                  <i class="fa fa-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteRecord(this)">
                                  <i class="fa fa-trash"></i>
                                </button>
                              </td>
                            </tr>
                            <tr><td>10</td><td>ECO-00-010</td><td><a href="https://docs.google.com/document/d/1Ok9sBp-Y6X87WeLdU5luLLO_9jNB5ETe/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true" target="_blank" style="color:#007bff;">Extension Service Request Form</a></td> <td>5 Years</td><td>5 Years</td><td>IN-USE</td>  
                              <td>
                                <button class="btn btn-sm btn-primary" onclick="editRecord(this)">
                                  <i class="fa fa-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteRecord(this)">
                                  <i class="fa fa-trash"></i>
                                </button>
                              </td>
                            </tr>
                            <tr><td>11</td><td>ECO-00-010</td><td><a href="https://docs.google.com/document/d/1R0FWvcPkzEQmWCChSIWPB6HtTnoVJXsz/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true"target="_blank" style="color:#007bff;">Extension Training Proposal Evaluation Form</a></td> <td>5 Years</td><td>5 Years</td><td>IN-USE</td>  
                              <td>
                                <button class="btn btn-sm btn-primary" onclick="editRecord(this)">
                                  <i class="fa fa-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteRecord(this)">
                                  <i class="fa fa-trash"></i>
                                </button>
                              </td>
                            </tr>
                            <tr><td>12</td><td>ECO-00-010</td><td><a href="https://docs.google.com/spreadsheets/d/18k7Iui74MN1PDIJZdhAOTvD2VVKZy4FD/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true" target="_blank" style="color:#007bff;">Project LIB (Line Item Budget)</a></td> <td>5 Years</td><td>5 Years</td><td>IN-USE</td>  
                              <td>
                                <button class="btn btn-sm btn-primary" onclick="editRecord(this)">
                                  <i class="fa fa-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteRecord(this)">
                                  <i class="fa fa-trash"></i>
                                </button>
                              </td>
                            </tr>
                            <tr><td>13</td><td>ECO-00-010</td><td><a href="https://docs.google.com/document/d/1igAgbZ4CE4q3PNHlyNZYsJ2EJoXhcTQU/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true" target="_blank" style="color:#007bff;">Evaluation Form for Partner Agency</a></td> <td>5 Years</td><td>5 Years</td><td>IN-USE</td>  
                              <td>
                                <button class="btn btn-sm btn-primary" onclick="editRecord(this)">
                                  <i class="fa fa-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteRecord(this)">
                                  <i class="fa fa-trash"></i>
                                </button>
                              </td>
                            </tr>
                            <tr><td>14</td><td>ECO-00-010</td><td><a href="https://docs.google.com/document/d/19V03XNZW0pUBAtkiaRwVDlP74xoCoFxY/edit?usp=sharing&ouid=114894177421069218209&rtpof=true&sd=true" target="_blank" style="color:#007bff;">Calendar of Activites</a></td> <td>5 Years</td><td>5 Years</td><td>IN-USE</td>  
                              <td>
                                <button class="btn btn-sm btn-primary" onclick="editRecord(this)">
                                  <i class="fa fa-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteRecord(this)">
                                  <i class="fa fa-trash"></i>
                                </button>
                              </td>
                            </tr>
                            <tr><td>15</td><td>ECO-00-010</td><td><a href="https://docs.google.com/document/d/1TR3gGuSa-YL88g2MyrGQiWpsV09xlHPZ/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true" target="_blank" style="color:#007bff;">Evaluation Criteria Form (Completed)</a></td> <td>5 Years</td><td>5 Years</td><td>IN-USE</td>  
                              <td>
                                <button class="btn btn-sm btn-primary" onclick="editRecord(this)">
                                  <i class="fa fa-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteRecord(this)">
                                  <i class="fa fa-trash"></i>
                                </button>
                              </td>
                            </tr>
                            <tr><td>16</td><td>ECO-00-010</td><td><a href="https://docs.google.com/document/d/1VfN_zrOMubFzQ2Jhdq1PN5D4ygwl_PyH/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true" target="_blank" style="color:#007bff;">Evaluation Criteria Form (Proposed)</a></td> <td>5 Years</td><td>5 Years</td><td>IN-USE</td>  
                              <td>
                                <button class="btn btn-sm btn-primary" onclick="editRecord(this)">
                                  <i class="fa fa-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteRecord(this)">
                                  <i class="fa fa-trash"></i>
                                </button>
                              </td>
                            </tr>
                            <tr><td>17</td><td>ECO-00-010</td><td><a href="https://docs.google.com/document/d/1p5fqAZFCyhkIJNjzonU23C-BvyVOvJf1/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true" target="_blank" style="color:#007bff;">Project Proposal Form for Technology Transfer</a></td> <td>5 Years</td><td>5 Years</td><td>IN-USE</td>  
                              <td>
                                <button class="btn btn-sm btn-primary" onclick="editRecord(this)">
                                  <i class="fa fa-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteRecord(this)">
                                  <i class="fa fa-trash"></i>
                                </button>
                              </td>
                            </tr>
                            <tr><td>18</td><td>ECO-00-010</td><td><a href="https://docs.google.com/document/d/1U8sdGUUo41aH5Y22ZgF2ingJtII39kmT/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true" target="_blank" style="color:#007bff;">Project Work Plan Form</a></td> <td>5 Years</td><td>5 Years</td><td>IN-USE</td>  
                              <td>
                                <button class="btn btn-sm btn-primary" onclick="editRecord(this)">
                                  <i class="fa fa-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteRecord(this)">
                                  <i class="fa fa-trash"></i>
                                </button>
                              </td>
                            </tr>
                            <tr><td>19</td><td>ECO-00-010</td><td><a href="https://docs.google.com/document/d/16MfnzeflPT36_Xad-vbHj5EkF22xnMHP/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true" target="_blank" style="color:#007bff;">Project Proposal Tempalte</a></td> <td>5 Years</td><td>5 Years</td><td>IN-USE</td>  
                              <td>
                                <button class="btn btn-sm btn-primary" onclick="editRecord(this)">
                                  <i class="fa fa-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteRecord(this)">
                                  <i class="fa fa-trash"></i>
                                </button>
                              </td>
                            </tr>
                            <tr><td>20</td><td>ECO-00-010</td><td><a href="https://docs.google.com/document/d/1F_77-5G5Eu0rOwZ3XJT9Agt2VQkfxiOz/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true" target="_blank" style="color:#007bff;">Project Monitoring Report Template</a></td> <td>5 Years</td><td>5 Years</td><td>IN-USE</td>  
                              <td>
                                <button class="btn btn-sm btn-primary" onclick="editRecord(this)">
                                  <i class="fa fa-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteRecord(this)">
                                  <i class="fa fa-trash"></i>
                                </button>
                              </td>
                            </tr>
                            <tr><td>21</td><td>ECO-00-010</td><td><a href="https://docs.google.com/document/d/1KgForyqbXMRV2SKdEt7AqseTrNH86dNK/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true" target="_blank" style="color:#007bff;">Project Evaluation Template</a></td> <td>5 Years</td><td>5 Years</td><td>IN-USE</td>  
                              <td>
                                <button class="btn btn-sm btn-primary" onclick="editRecord(this)">
                                  <i class="fa fa-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteRecord(this)">
                                  <i class="fa fa-trash"></i>
                                </button>
                              </td>
                            </tr>
                            <tr><td>22</td><td>ECO-00-010</td><td><a href="https://docs.google.com/document/d/1kF5c6yELdoAS2bVl1lbJUHSp7bpT--n2/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true" target="_blank" style="color:#007bff;">Terminal & Progress Report Template</a></td> <td>5 Years</td><td>5 Years</td><td>IN-USE</td>  
                              <td>
                                <button class="btn btn-sm btn-primary" onclick="editRecord(this)">
                                  <i class="fa fa-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteRecord(this)">
                                  <i class="fa fa-trash"></i>
                                </button>
                              </td>
                            </tr>
                            <tr><td>23</td><td>ECO-00-010</td><td><a href="https://docs.google.com/document/d/1vo2LhbB0lewZh8Lf_1C1juhCDwh_ehPu/edit?usp=drive_link&ouid=114894177421069218209&rtpof=true&sd=true" target="_blank" style="color:#007bff;">Activity Proposal Tempalate</a></td> <td>5 Years</td><td>5 Years</td><td>IN-USE</td>  
                              <td>
                                <button class="btn btn-sm btn-primary" onclick="editRecord(this)">
                                  <i class="fa fa-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteRecord(this)">
                                  <i class="fa fa-trash"></i>
                                </button>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <p style="font-size: 13px; color: gray;">*Click on the blue title to fill out the corresponding Google Form.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
@endsection