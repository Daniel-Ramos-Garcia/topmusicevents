@extends('admin.layouts.app-message')
@section('content')
<!-- BEGIN PAGE -->
<div class="page-content">
    <div class="content">
        <div class="row" id="inbox-wrapper">
            <div class="col-md-12">
                <div class="grid simple">
                    <div class="grid-body no-border email-body">
                        <br>
                        <div class="row-fluid">
                            <div class="row-fluid dataTables_wrapper">
                                <h2 class=" inline">Inbox </h2>
                            </div>
                            <br />

                            <div id="email-list">
                                <table class="table table-striped" id="">
                                    <thead>
                                        <tr>
                                            <th class="small-cell">
                                                <div class="checkbox check-success ">
                                                    <input id="all" type="checkbox" class="check">
                                                    <label for="all"></label>
                                                </div>
                                            </th>
                                            <th class="small-cell">Check</th>
                                            <th class="small-cell">Name</th>
                                            <th style='width: 300px;'>From</th>
                                            <th>Content</th>
                                            <th class="medium-cell">Received Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($messages as $message)
                                        <tr message-id="{{ $message->id }}">
                                            <td class="small-cell v-align-middle">
                                                <div class="checkbox check-success ">
                                                    <input id="{{ $message->id }}" type="checkbox" class="check"
                                                        name="ids">
                                                    <label for="{{ $message->id }}"></label>
                                                </div>
                                                <span style="display: none">{{ $message->id }}</span>
                                            </td>

                                            <td class="small-cell v-align-middle">
                                                <div class="star">
                                                    <input id="check{{ $message->id }}" type="checkbox" value="1"
                                                        @if($message->checked == 1)
                                                    {{ 'checked' }}
                                                    @endif>
                                                    <label for="check{{ $message->id }}"></label>
                                                </div>
                                            </td>
                                            <td class="clickable v-align-middle">
                                                {{ $message->name }}
                                            </td>
                                            <td class="clickable v-align-middle">
                                                @if(App\Models\User::where('email', $message->from)->exists())
                                                {{ App\Models\User::where('email', $message->from)->first()->name }}->
                                                @endif{{ $message->from }}

                                            </td>
                                            <td class="clickable tablefull v-align-middle">
                                                @if(!App\Models\User::where('email', $message->from)->exists())
                                                <span class="label bg-red text-white">Quote</span>
                                                @endif
                                                <span class="muted">
                                                    {{ strip_tags(substr($message->content, 0, 100)) }}
                                                    @if(strip_tags(substr($message->content, 0, 100)) > 100)
                                                    {{ '...' }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="clickable">
                                                <span
                                                    class="muted">@if($message->created_at != null) {{ with($message->created_at)->format('d/m/y H:i A') }} @endif
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
    <div class="admin-bar" id="quick-access">
        <div class="admin-bar-inner">
            <button class="btn btn-danger  btn-add" type="button" onclick="movetrash();"><i class="icon-trash"></i> Move
                to trash</button>
            <button class="btn btn-white  btn-cancel" type="button">Cancel</button>
        </div>
    </div>
    <!-- END PAGE -->
</div>
@endsection

@section('scripts')
<script src="{{ asset('adminn/assets/js/email_comman.js') }}" type="text/javascript"></script>
@if ($msg = Session::get('success'))
<script>
    $(document).ready(function () {
        Messenger().post({
            message: "{{$msg}}",
            type: 'success',
            showCloseButton: true
        });
    });
</script>
@endif
<script>
    $('.clickable').click(function(){
        id = $(this).parents('tr').attr('message-id');
        $('#check'+id).attr('checked', true);
        window.location.href = 'email/'+id+'/show';
    });
    $('#all').change(function(){
        if($(this).is(':checked')){
            $('.check').attr('checked', true);
        }else{
            $('.check').removeAttr('checked');
        }
    });
    function movetrash(){
        var ids = [];
        $('.check').each(function(){
            if($('td').find(this).is(':checked')){
                ids.push($(this).attr('id'));
            }
        });
        $.ajax({
            url: 'email/movetotrash',
            data: {
                'ids' : ids,
            },
            type: 'get',
            success: function(){
                location.reload("{{ action('admin\MessageController@trash') }}");
            }
        });
    }
    $('.message-tab li:nth-child(1)').addClass('active');
</script>
@endsection
