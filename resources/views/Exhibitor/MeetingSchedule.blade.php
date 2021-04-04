@extends('layouts.Panel')

@section("Head")


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
          type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="{{asset("css/bootstrap-limitless.css")}}" rel="stylesheet" type="text/css">
    <link href="{{asset("css/layout.min.css")}}" rel="stylesheet" type="text/css">
    <link href="{{asset("css/components.min.css")}}" rel="stylesheet" type="text/css">
    <link href="{{asset("css/colors.min.css")}}" rel="stylesheet" type="text/css">
    <link href="{{asset("css/hasan-custom.css")}}" rel="stylesheet" type="text/css">

    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="{{asset("js/jquery.min.js")}}"></script>
    <script src="{{asset("js/bootstrap.bundler.js")}}"></script>
    <script src="{{asset("js/blockui.min.js")}}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="{{asset("js/d3.min.js")}}"></script>
    <script src="{{asset("js/d3tooltip.js")}}"></script>
    <script src="{{asset("js/switchery.min.js")}}"></script>
    <script src="{{asset("js/momment.min.js")}}"></script>
    <script src="{{asset("js/app2.js")}}"></script>
    <script src="{{asset("js/dashboard.js")}}"></script>
    <script src="https://use.fontawesome.com/fd423b8d2f.js"></script>
    <!-- /theme JS files -->


@endsection


@section('content')



    {{--    Hasan start Here !!!!--}}




    <body style="background: url('{{\App\Site::ExhibitorBackground()}}') no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        height: 100%;
        ;">
    <div>


    @include("Sidebars.exhibitor-sidebar")







    <!-- Main content -->


        <div class="content-wrapper" style="overflow-x: hidden">

            <!-- Content area -->
            <div class="content">

                <!-- Main charts -->
                <div class="row">
                    <div class="col-xl-12">
                        <!-- Traffic sources -->
                        <div class="card pc-height-visitor-meeting"
                             style="background-color:#006B63;color: white;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <h3 class="text-dark">Dates</h3>


                                        @foreach($Days as $day)


                                            @if (\request()->input('Day') && \request()->input('Day') == $day)

                                                <a href="?Day={{$day}}"
                                                   class="btn btn-primary text-white w-100 mb-2">{{$day}}</a>

                                            @else

                                                <a href="?Day={{$day}}"
                                                   class="btn btn-outline-dark text-white w-100 mb-2">{{$day}}</a>

                                            @endif





                                        @endforeach


                                    </div>

                                    @if (\request()->input('Day'))

                                        <div class="col-md-3 mt-3 mt-md-0"
                                             style="height: 690px;border: 2px solid white;border-radius: 5px;">
                                            <p class="mt-2 mb-2">
                                               {{__("message.SelectAvailableTime")}}
                                            </p>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row">


                                                        @foreach($times as $time)


                                                            @php


                                                                $date = \Carbon\Carbon::parse(\request()->input('Day') . ' ' . $time)->format('Y-m-d H:i:s');
                                                                 $meeting_exists = \App\Meeting::where('owner_id', Auth::user()->id)->where('start_time', $date)->first();


                                                            @endphp


                                                            @if ($meeting_exists != null)

                                                                <div class="col-md-6 mt-2">
                                                                    <a href="{{route('Exhibitor.MeetingDeActivateTime', ['day' => \request()->input('Day'), 'time' => $time])}}"
                                                                       class="time btn btn-success w-100">{{$time}}</a>
                                                                </div>
                                                            @else



                                                                <div class="col-md-6 mt-2">
                                                                    <a href="{{route('Exhibitor.MeetingActivateTime', ['day' => \request()->input('Day'), 'time' => $time])}}"
                                                                       class="time btn btn-dark w-100">{{$time}}</a>
                                                                </div>
                                                            @endif








                                                        @endforeach


                                                    </div>
                                                </div>
                                                <div class="col-md-1"></div>
                                            </div>

                                        </div>



                                        <div class="col-md-7">
                                            <h4 class="mt-2 mt-md-0">
                                                {{__("message.RequestedVisitorsForMeeting")}}
                                            </h4>
                                            <div style="height: 350px;overflow-y: auto">
                                                <table
                                                    class="table table-bordered table-striped table-hover table-light text-center">
                                                    <thead>
                                                    <th>{{__("message.Visitor")}} {{__("message.Name")}}</th>
                                                    <th>{{__("message.RequestedDate")}}</th>
                                                    <th>{{__("message.Status")}}</th>
                                                    <th>{{__("message.Action")}}</th>
                                                    </thead>
                                                    <tbody>

                                                    @foreach($meeting_requests as $meet_req)


                                                        @php

                                                            $user = \App\User::find($meet_req->user_id);

                                                        @endphp

                                                        <tr >
                                                            <td ><a href="{{\request()->fullUrlWithQuery(['visitor' => $user->id])}}">{{$user->UserName}}</a></td>
                                                            <td>{{$meet_req->request_time}}</td>
                                                            <td>{{$meet_req->status}}</td>


                                                            @if ($meet_req->status == "none")

                                                                <td>
                                                                    <div class="btn-group w-100">
                                                                        <a class="btn btn-success w-100" href="{{route('Exhibitor.MeetingAccept', $meet_req->id)}}">
                                                                            {{__("message.Accept")}}
                                                                        </a>
                                                                        <a class="btn btn-danger w-100" href="{{route('Exhibitor.MeetingReject', $meet_req->id)}}">
                                                                            {{__("message.Reject")}}
                                                                        </a>
                                                                    </div>
                                                                </td>

                                                                @elseif ($meet_req->status == "rejected")

                                                                <td>


                                                                        <a class="btn btn-danger w-100" href="#">
                                                                            {{__("message.Rejected")}}
                                                                        </a>

                                                                </td>




                                                            @elseif ($meet_req->status == "accepted")






                                                                <td>
                                                                    <div class="btn-group w-100">

                                                                        @if (\Carbon\Carbon::now()->gte(Carbon\Carbon::parse($meet_req->request_time))  && \Carbon\Carbon::now()->lte(Carbon\Carbon::parse($meet_req->request_time)->addMinutes(30)) )

                                                                            <a target="_blank" class="btn btn-primary w-100" href="{{route('Exhibitor.meeting.join', $meet_req->id )}}">
                                                                               {{__("message.EnterMeeting")}}

                                                                            </a>

                                                                            @else

                                                                            <button disabled=""  class="btn btn-dark w-100">

                                                                                {{__("message.NoAction")}}

                                                                            </button>



                                                                        @endif



                                                                        <a class="btn btn-danger w-100" href="{{route('Exhibitor.MeetingReject',$meet_req->id )}}">
                                                                            {{__("message.Reject")}}
                                                                        </a>

                                                                    </div>
                                                                </td>
                                                            @endif


                                                        </tr>


                                                    @endforeach


                                                    </tbody>
                                                </table>
                                            </div>


                                            @if (isset($visitor))


                                                <div class="mt-3"
                                                     style="border: 2px solid black;border-radius: 5px;height: 288px;overflow-y: auto;overflow-x: hidden">
                                                    <h3 class="mt-2 ml-2">{{__("message.VisitorInformation")}}</h3>

                                                    <div class="row">
                                                        <div class="col-12 text-center">
                                                            <h1>
                                                                {{$visitor->formRule}}
                                                            </h1>
                                                        </div>
                                                        <div class="col-md-5 ml-2 mt-2">
                                                            <p><span
                                                                    style="font-weight: bolder">{{__("message.Name")}}: </span>{{$visitor->FirstName}}
                                                            </p>
                                                            <p><span
                                                                    style="font-weight: bolder">{{__("message.LastName")}}: </span>{{$visitor->Lastname}}
                                                            </p>

                                                            @if($visitor->Profession != null)


                                                            <p><span
                                                                    style="font-weight: bolder">{{__("message.Profession")}}: </span>{{$visitor->Profession}}
                                                            </p>

                                                            @endif



                                                            <p><span
                                                                    style="font-weight: bolder">{{__("message.City")}}: </span>{{$visitor->City}}
                                                            </p>


                                                            @if($visitor->InterNationalPrograms != null)


                                                            <p><span
                                                                    style="font-weight: bolder">{{__("message.InternationalPrograms")}}: </span>{{$visitor->InterNationalPrograms}}
                                                            </p>


                                                            @endif
                                                            <p><span
                                                                    style="font-weight: bolder">{{__("message.WebSite")}}: </span>{{$visitor->website}}
                                                            </p>

                                                            @if($visitor->userComapnyName != null)


                                                            <p><span
                                                                    style="font-weight: bolder">{{__("message.CompanyName")}}: </span>{{$visitor->userComapnyName}}
                                                            </p>

                                                            @endif

                                                            @if($visitor->profile != null)


                                                            <p><span
                                                                    style="font-weight: bolder">{{__("message.Profile")}}: </span>{{$visitor->profile}}
                                                            </p>

                                                            @endif

                                                            @if($visitor->subProfile != null)


                                                            <p><span
                                                                    style="font-weight: bolder">{{__("message.SubProfile")}}: </span>{{$visitor->subProfile}}
                                                            </p>

                                                            @endif
                                                        </div>
                                                        <div class="col-md-5 ml-2 mt-2">
                                                            <p><span
                                                                    style="font-weight: bolder">{{__("message.Title")}}: </span>{{$visitor->Gender}}
                                                            </p>
                                                            <p><span
                                                                    style="font-weight: bolder">{{__("message.Country")}}: </span>{{$visitor->Country}}
                                                            </p>


                                                            @if($visitor->email != null)


                                                            <p><span
                                                                    style="font-weight: bolder">{{__("message.Email")}}: </span>{{$visitor->email}}
                                                            </p>

                                                            @endif

                                                            @if($visitor->city != null)


                                                            <p><span
                                                                    style="font-weight: bolder">{{__("message.City")}}: </span>{{$visitor->city}}
                                                            </p>

                                                            @endif


                                                            @if($visitor->BirthDate != null)

                                                            <p><span
                                                                    style="font-weight: bolder">{{__("message.BirthDate")}}: </span>{{$visitor->BirthDate}}
                                                            </p>

                                                            @endif


                                                            @if($visitor->companyAddress != null)


                                                            <p><span
                                                                    style="font-weight: bolder">{{__("message.CompanyAddress")}}: </span>{{$visitor->companyAddress}}
                                                            </p>

                                                            @endif

                                                            @if($visitor->zipCode != null)


                                                            <p><span
                                                                    style="font-weight: bolder">{{__("message.Zipcode")}}: </span>{{$visitor->zipCode}}
                                                            </p>

                                                            @endif

                                                            @if($visitor->mainCompany != null)



                                                            <p><span
                                                                    style="font-weight: bolder">{{__("message.MainCompany")}}: </span>{{$visitor->mainCompany}}
                                                            </p>


                                                            @endif

                                                            @if($visitor->institutionEmail != null)


                                                            <p><span
                                                                    style="font-weight: bolder">{{__("message.InstitutionEmail")}}: </span>{{$visitor->institutionEmail}}
                                                            </p>

                                                            @endif

                                                            @if($visitor->institution != null)


                                                            <p><span
                                                                    style="font-weight: bolder">{{__("message.Institution")}}: </span>{{$visitor->institution}}
                                                            </p>

                                                            @endif


                                                            @if($visitor->education != null)


                                                            <p><span
                                                                    style="font-weight: bolder">{{__("message.Education")}}: </span>{{$visitor->education}}
                                                            </p>

                                                            @endif


                                                            @if($visitor->countryStudy != null)


                                                            <p><span
                                                                    style="font-weight: bolder">{{__("message.CountryStudy")}}: </span>{{$visitor->countryStudy}}
                                                            </p>


                                                            @endif

                                                            @if($visitor->InterestedDegree != null)

                                                            <p><span
                                                                    style="font-weight: bolder">{{__("message.InterestedDegree")}}: </span>{{$visitor->InterestedDegree}}
                                                            </p>

                                                            @endif


                                                            @if($visitor->InterestedField != null)


                                                            <p><span
                                                                    style="font-weight: bolder">{{__("message.InterestedField")}}: </span>{{$visitor->InterestedField}}
                                                            </p>


                                                            @endif


                                                            @if($visitor->languageOfStudy != null)


                                                            <p><span
                                                                    style="font-weight: bolder">{{__("message.LanguageOfStudy")}}: </span>{{$visitor->languageOfStudy}}
                                                            </p>


                                                            @endif



                                                            @if($visitor->onlineDegreeProgram != null)


                                                            <p><span
                                                                    style="font-weight: bolder">{{__("message.OnlineDegreeProgram")}}: </span>{{$visitor->onlineDegreeProgram}}
                                                            </p>

                                                            @endif

                                                            @if($visitor->interestedScholarShip != null)

                                                            <p><span
                                                                    style="font-weight: bolder">{{__("message.InterestedScholarShip")}}: </span>{{$visitor->interestedScholarShip}}
                                                            </p>

                                                            @endif

                                                            @if($visitor->currentLevelOfEducation != null)


                                                            <p><span
                                                                    style="font-weight: bolder">{{__("message.CurrentLevelOfEducation")}}: </span>{{$visitor->currentLevelOfEducation}}
                                                            </p>

                                                            @endif


                                                            @if($visitor->position != null)


                                                            <p><span
                                                                    style="font-weight: bolder">{{__("message.Position")}}: </span>{{$visitor->position}}
                                                            </p>

                                                            @endif

                                                            @if($visitor->admissionSemester != null)


                                                            <p><span
                                                                    style="font-weight: bolder">{{__("message.AdmissionSemester")}}: </span>{{$visitor->admissionSemester}}
                                                            </p>

                                                            @endif


                                                            @if($visitor->professionInterestedToApply != null)


                                                            <p><span
                                                                    style="font-weight: bolder">{{__("message.ProfessionInterestedToApply")}}: </span>{{$visitor->professionInterestedToApply}}
                                                            </p>

                                                            @endif

                                                            @if($visitor->organization != null)

                                                                <p>
                                                                    <span
                                                                        style="font-weight: bolder">{{__("message.Organization")}}:
                                                                    </span>
                                                                    {{$visitor->organization}}
                                                                </p>

                                                            @endif

                                                        </div>
                                                    </div>

                                                </div>

                                            @endif


                                        </div>



                                    @endif


                                </div>
                            </div>
                        </div>
                        <!-- /traffic sources -->
                    </div>
                </div>
                <!-- /main charts -->
            </div>
            <!-- /content area -->
        </div>


        <!--/Main Content  -->
    </div>


    </div>

    <script>


        $('a[href*="MeetingActivateTime"]').click(function (e) {
            e.preventDefault();
            var link = $(this).attr('href');


            Swal.fire({
                title: 'Do you want to Activate This Meeting?',
                showDenyButton: true,
                confirmButtonText: `Active`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    window.location.href = link
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'success')
                }
            })


        });


        $('a[href*="MeetingDeActivate"]').click(function (e) {
            e.preventDefault();
            var link = $(this).attr('href');


            Swal.fire({
                title: 'Do you want to Deactivate This Meeting?',
                showDenyButton: true,
                confirmButtonText: `Deactive`,
                denyButtonText: `Cancel`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    window.location.href = link
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'success')
                }
            })


        });


    </script>

    </body>






@endsection
