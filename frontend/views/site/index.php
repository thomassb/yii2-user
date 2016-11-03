<?php
/* @var $this yii\web\View */

$this->title = 'Dashboard';
?>
<div class="site-index">
    <div class="col-sm-6">
<div class="box box-solid ">
            <div class="box-header bg-blue-gradient">
                <i class="fa fa-calendar"></i>

                <h3 class="box-title">Bulletins</h3>
                <!-- tools box -->
                <div class="pull-right box-tools">
                    <!-- button with a dropdown -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bars"></i></button>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <li><a href="#">Add bulletin item</a></li>
                            <li><a href="#">Edit bulletins</a></li>
                            <li class="divider"></li>
                            <li><a href="#">View all bulletins</a></li>
                        </ul>
                    </div>
                    <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                </div>
                <!-- /. tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body ">
               <div id="timeline" class="tab-pane active">
                <!-- The timeline -->
                <ul class="timeline timeline-inverse">
                  <!-- timeline time label -->
                  <li class="time-label">
                        <span class="bg-red">
                          10 Sep. 2016
                        </span>
                  </li>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-envelope bg-blue"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

                      <h3 class="timeline-header"><a href="#">Lorem ipsum </a></h3>

                      <div class="timeline-body">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque 
                        in nisl bibendum ante pellentesque aliquam. Integer hendrerit pharetra 
                        sapien eget aliquam. Sed nec ante eros. Curabitur vel nisi non sapien 
                        pulvinar pulvinar. Duis sodales, neque vel lobortis laoreet, nunc mi accumsan
                        ....
                      </div>
                      <div class="timeline-footer">
                        <a class="btn btn-primary btn-xs">Read more</a>
                       
                      </div>
                    </div>
                  </li>
                    <li class="time-label">
                        <span class="bg-red">
                          8 Sep. 2016
                        </span>
                  </li>
                          <li>
                    <i class="fa fa-envelope bg-blue"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

                      <h3 class="timeline-header"><a href="#">Lorem ipsum </a></h3>

                      <div class="timeline-body">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque 
                        in nisl bibendum ante pellentesque aliquam. Integer hendrerit pharetra 
                        sapien eget aliquam. Sed nec ante eros. Curabitur vel nisi non sapien 
                        pulvinar pulvinar. Duis sodales, neque vel lobortis laoreet, nunc mi accumsan
                        ....
                      </div>
                      <div class="timeline-footer">
                        <a class="btn btn-primary btn-xs">Read more</a>
                       
                      </div>
                    </div>
                  </li>
                 
                  <li>
                    <i class="fa fa-clock-o bg-gray"></i>
                  </li>
                </ul>
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-black">

                <!-- /.row -->
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-solid bg-green-gradient">
            <div class="box-header">
                <i class="fa fa-calendar"></i>

                <h3 class="box-title">Calendar</h3>
                <!-- tools box -->
                <div class="pull-right box-tools">
                    <!-- button with a dropdown -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bars"></i></button>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <li><a href="#">Add new event</a></li>
                            <li><a href="#">Clear events</a></li>
                            <li class="divider"></li>
                            <li><a href="#">View calendar</a></li>
                        </ul>
                    </div>
                    <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                </div>
                <!-- /. tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <!--The calendar -->
                <div id="calendar" class="home-datepicker">
               <?php
               echo kartik\widgets\DatePicker::widget([
    'name' => 'dp_5',
    'type' => kartik\widgets\DatePicker::TYPE_INLINE,
   // 'value' => 'Tue, 23-Feb-1982',
    'pluginOptions' => [
        'format' => 'D, dd-M-yyyy',
      
    ],
    'options' => [
        'style'=>'width:100%',
        // you can hide the input by setting the following
         'class' => 'hide '
    ]
]);?>
               </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-black">

                <!-- /.row -->
            </div>
        </div>
    </div>


</div>
<?php
//$this->registerJs("
//    $(function () {
//     $('#calendar').datepicker();
// })"
//, yii\web\View::POS_END, 'search');
?>