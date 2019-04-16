<style>
    .profile-avatar-container {
        position: relative;
        width: 100px;
        margin: 0 auto;
    }

    .profile-avatar-container .profile-user-img {
        width: 100px;
        height: 100px;
    }

    .profile-avatar-container .profile-avatar-text {
        display: none;
    }

    .profile-avatar-container:hover .profile-avatar-text {
        display: block;
        position: absolute;
        height: 100px;
        width: 100px;
        background: #444;
        opacity: .6;
        color: #fff;
        top: 0;
        left: 0;
        line-height: 100px;
        text-align: center;
    }

    .profile-avatar-container button {
        position: absolute;
        top: 0;
        left: 0;
        width: 100px;
        height: 100px;
        opacity: 0;
    }
</style>
<div class="row animated fadeInRight">
    <div class="col-md-4">
        <div class="box box-success">
            <div class="panel-heading">
                {{lang('Profile')}}
            </div>
            <div class="panel-body">

                <form id="update-form" role="form" data-toggle="validator" method="POST" action="{{url('profile/update')}}">
                    <input type="hidden" id="c-avatar" name="row[avatar]" value="{{$admin['avatar']}}"/>
                    <div class="box-body box-profile">

                        <div class="profile-avatar-container">
                            <img class="profile-user-img img-responsive img-circle plupload" src="{{get_storage_image($admin['avatar'])||get_storage_image($admin['cdnurl'])}}" alt="">
                            <div class="profile-avatar-text img-circle">{{lang('Click to edit')}}</div>
                            <button id="plupload-avatar" class="plupload" data-input-id="c-avatar"><i class="fa fa-upload"></i> {{lang('Upload')}}</button>
                        </div>

                        <h3 class="profile-username text-center">{{$admin['username']}}</h3>

                        <p class="text-muted text-center">{{$admin['email']}}</p>
                        <div class="form-group">
                            <label for="username" class="control-label">{{lang(('Username'))}}:</label>
                            <input type="text" class="form-control" id="username" name="row[username]" value="{{$admin['username']}}" disabled/>
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label">{{lang('Email')}}:</label>
                            <input type="text" class="form-control" id="email" name="row[email]" value="{{$admin['email']}}" data-rule="required;email"/>
                        </div>
                        <div class="form-group">
                            <label for="nickname" class="control-label">{{lang('Nickname')}}:</label>
                            <input type="text" class="form-control" id="nickname" name="row[nickname]" value="{{$admin['nickname']}}" data-rule="required"/>
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">{{lang('Password')}}:</label>
                            <input type="password" class="form-control" id="password" placeholder="{{lang('password change')}}" autocomplete="new-password" name="row[password]" value="" data-rule="password"/>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">{{lang('Submit')}}</button>
                            <button type="reset" class="btn btn-default">{{lang('Reset')}}</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

    </div>
    <div class="col-md-8">
        <div class="panel panel-default panel-intro panel-nav">
            <div class="panel-heading">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#one" data-toggle="tab"><i class="fa fa-list"></i> {{lang('Admin log')}}</a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="one">
                        <div class="widget-body no-padding">
                            <div id="toolbar" class="toolbar">
                                {!! build_toolbar('refresh') !!}
                            </div>
                            <table id="table" class="table table-striped table-bordered table-hover" width="100%">

                            </table>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>