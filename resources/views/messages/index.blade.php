@extends('layouts.app')

@section('content')
<div id="content">
    @include('layouts.partials.topnav')

    <div class="midde_cont">
        <div class="container-fluid">
            {{-- ============================ --}}
            {{-- Page Header --}}
            {{-- ============================ --}}
            <div class="row column_title">
                <div class="col-md-12">
                    <div class="page_title d-flex align-items-center justify-content-between">
                        <h2>Messages Center</h2>
                    </div>
                </div>
            </div>

            {{-- ============================ --}}
            {{-- Main Tabs: Proposals / Messages --}}
            {{-- ============================ --}}
            <ul class="nav nav-tabs mt-3" id="mainMessagesTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="proposals-tab" data-bs-toggle="tab"
                        data-bs-target="#proposals" type="button" role="tab"
                        aria-controls="proposals" aria-selected="true">
                        <i class="fa fa-file-text-o me-1"></i> Proposals
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="messages-tab" data-bs-toggle="tab"
                        data-bs-target="#messages" type="button" role="tab"
                        aria-controls="messages" aria-selected="false">
                        <i class="fa fa-envelope-o me-1"></i> Messages
                    </button>
                </li>
            </ul>

            <div class="tab-content border border-top-0 p-3 bg-white rounded-bottom" id="mainMessagesTabContent">
                {{-- ============================ --}}
                {{-- PROPOSALS TAB --}}
                {{-- ============================ --}}
                <div class="tab-pane fade show active" id="proposals" role="tabpanel" aria-labelledby="proposals-tab">
                    @if($pendingProposals->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Location</th>
                                        <th>Target Agenda</th>
                                        <th>Approved Budget</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingProposals as $proposal)
                                        <tr>
                                            <td>{{ $proposal->id }}</td>
                                            <td>{{ $proposal->title }}</td>
                                            <td>{{ $proposal->location ?? 'N/A' }}</td>
                                            <td>{{ $proposal->target_agenda ?? 'N/A' }}</td>
                                            <td>{{ number_format($proposal->approved_budget ?? 0, 2) }}</td>
                                            <td>
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            </td>
                                            <td>{{ $proposal->created_at->format('M d, Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mt-3">
                            No pending proposals found.
                        </div>
                    @endif
                </div>

                {{-- ============================ --}}
                {{-- MESSAGES TAB --}}
                {{-- ============================ --}}
                <div class="tab-pane fade" id="messages" role="tabpanel" aria-labelledby="messages-tab">
                    {{-- Inner Pills: Public / Private --}}
                    <ul class="nav nav-pills mb-3" id="messageTypeTabs" role="tablist">
                        <li class="nav-item mr-2" role="presentation">
                            <button class="nav-link active" id="public-tab" data-bs-toggle="tab"
                                data-bs-target="#public-messages" type="button" role="tab"
                                aria-controls="public-messages" aria-selected="true">
                                <i class="fa fa-globe me-1"></i> Public Board
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="private-tab" data-bs-toggle="tab"
                                data-bs-target="#private-messages" type="button" role="tab"
                                aria-controls="private-messages" aria-selected="false">
                                <i class="fa fa-lock me-1"></i> Private Messages
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="messageTypeTabsContent">
                        {{-- PUBLIC MESSAGES --}}
                        <div class="tab-pane fade show active" id="public-messages" role="tabpanel" aria-labelledby="public-tab">
                            {{-- Form to post public message --}}
                            <form action="{{ route('messages.public.store') }}" method="POST" class="mb-3">
                                @csrf
                                <div class="mb-2">
                                    <label class="form-label fw-bold">Post to Public Board</label>
                                    <textarea name="body" class="form-control @error('body') is-invalid @enderror"
                                              rows="3" placeholder="Write a message that everyone can see...">{{ old('body') }}</textarea>
                                    @error('body')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fa fa-paper-plane"></i> Send
                                </button>
                            </form>

                            <hr>

                            {{-- List of public messages --}}
                            @if($publicMessages->count())
                                <div class="list-group">
                                    @foreach($publicMessages as $msg)
                                        <div class="list-group-item">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <strong>{{ $msg->user->name ?? 'User #'.$msg->user_id }}</strong>
                                                </div>
                                                <small class="text-muted">{{ $msg->created_at->diffForHumans() }}</small>
                                            </div>
                                            <p class="mb-0 mt-1">{{ $msg->body }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted">No public messages yet. Be the first to say something!</p>
                            @endif
                        </div>

                        {{-- PRIVATE MESSAGES --}}
                        <div class="tab-pane fade" id="private-messages" role="tabpanel" aria-labelledby="private-tab">
                            {{-- Form to send private message --}}
                            <form action="{{ route('messages.private.store') }}" method="POST" class="mb-3">
                                @csrf
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Send to</label>
                                        <select name="recipient_id"
                                                class="form-select @error('recipient_id') is-invalid @enderror">
                                            <option value="">-- Select user --</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}"
                                                    {{ old('recipient_id') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name ?? ($user->first_name.' '.$user->last_name ?? 'User #'.$user->id) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('recipient_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label fw-bold">Message</label>
                                        <textarea name="body"
                                                  class="form-control @error('body') is-invalid @enderror"
                                                  rows="3"
                                                  placeholder="Write a private message...">{{ old('body') }}</textarea>
                                        @error('body')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success btn-sm mt-2">
                                    <i class="fa fa-paper-plane"></i> Send Private
                                </button>
                            </form>

                            <hr>

                            {{-- List of private messages involving current user --}}
                            @if($privateMessages->count())
                                <div class="list-group">
                                    @foreach($privateMessages as $msg)
                                        @php
                                            $fromMe = $msg->sender_id === auth()->id();
                                            $otherUser = $fromMe ? $msg->recipient : $msg->sender;
                                        @endphp
                                        <div class="list-group-item">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    @if($fromMe)
                                                        <span class="badge bg-primary me-1">You →</span>
                                                    @else
                                                        <span class="badge bg-secondary me-1">{{ $otherUser->name ?? 'User #'.$otherUser->id }}</span>
                                                        <span>→ You</span>
                                                    @endif
                                                    <strong>
                                                        {{ $otherUser->name ?? ($otherUser->first_name.' '.$otherUser->last_name ?? 'User #'.$otherUser->id) }}
                                                    </strong>
                                                </div>
                                                <small class="text-muted">{{ $msg->created_at->diffForHumans() }}</small>
                                            </div>
                                            <p class="mb-0 mt-1">{{ $msg->body }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted">No private messages yet.</p>
                            @endif
                        </div>
                    </div>
                </div>

            </div> {{-- /tab-content --}}
        </div> {{-- /container-fluid --}}
    </div> {{-- /midde_cont --}}
</div>
@endsection
