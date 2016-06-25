
<h6>There are {{$count}} users</h6>
<table class="table table-hover table-bordered">
    <thead>
        <tr>
            @if ($user->id == 1)
                <th class="text-center blue white-text col-md-1"></th>
            @endif
            <th class="text-center blue white-text">Username</th>
            <th class="text-center blue white-text">Email</th>
            <th class="text-center blue white-text">Role</th>
            <th class="text-center blue white-text">Joined</th>
        </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
        @if ($super->id == 1)
            <td class="text-center">
                <form method="post" action="{{ route('admin.delete', $user->id) }}" class="delete_form_user">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="DELETE">
                    <button id="delete-user-btn">
                        <i class="fa fa-trash red-text" aria-hidden="true"></i>
                    </button>
                    
                </form>
        @endif
            <td>
                {{ $user->username }}
            </td>
            <td>
                {{ $user->email }}
            </td>
            <td>
            @if ($super->id == 1)
                <a data-toggle="modal" href='#modal-{{$user->id}}'>
                    <i class="fa fa-pencil green-text" aria-hidden="true"></i>
                </a>
                <div class="modal fade" id="modal-{{$user->id}}">
                    <div class="modal-dialog">
                    <form action="{{route('admin.pages.user.changerole')}}" method="POST" role="form">
                    <input type="hidden" name="_method" value="put">
                    <input type="hidden" name="id" value="{{$user->id}}">
                    {{csrf_field()}}
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Change User Role</h4>
                            </div>
                            <div class="modal-body">
                                <select name="admin" id="input" class="form-control" required="required">
                                    <option value="0">Member</option>
                                    <option value="1">Admin</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-sm btn-primary">Save changes</button>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            @endif
                @if ($user->admin == 1)
                    admin
                @else
                    member
                @endif
            </td>
            <td>
                {{ prettyDate($user->created_at) }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>