<div class="panel panel-default panel-intro">
    {!! build_heading() !!}

    <div class="panel-body">
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active in" id="one">
                <div class="widget-body no-padding">
                    <div id="toolbar" class="toolbar">
                        {!! build_toolbar('refresh') !!}
                        @if(input('multiple') == 'true')
                            <a class="btn btn-danger btn-choose-multi"><i class="fa fa-check"></i> {{lang('Choose')}}
                            </a>
                        @endif
                    </div>
                    <table id="table" class="table table-bordered table-hover" width="100%">

                    </table>
                </div>
            </div>

        </div>
    </div>
</div>