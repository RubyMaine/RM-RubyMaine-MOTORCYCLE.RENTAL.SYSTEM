<h1>Добро пожаловать в СИСТЕМУ ПРОКАТА МОТОЦИКЛОВ</h1>
<hr>
<div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-light elevation-1"><i class="fas fa-th-list"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"> Общее количество категорий </span>
                <span class="info-box-number">
                  <?php 
                    $category = $conn->query("SELECT count(id) as total FROM categories  where status = '1'")->fetch_assoc()['total'];
                    echo number_format($category);
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-copyright"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"> Бренды </span>
                <span class="info-box-number">
                  <?php 
                    $brands = $conn->query("SELECT count(id) as total FROM `brand_list` where status = '1' ")->fetch_assoc()['total'];
                    echo number_format($brands);
                  ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-motorcycle"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"> Мотоциклы </span>
                <span class="info-box-number">
                <?php 
                    $bike = $conn->query("SELECT count(id) as total FROM `bike_list` where status = '1' ")->fetch_assoc()['total'];
                    echo number_format($bike);
                  ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"> Клиенты </span>
                <span class="info-box-number">
                <?php 
                    $clients = $conn->query("SELECT count(id) as total FROM `clients`")->fetch_assoc()['total'];
                    echo number_format($clients);
                  ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
        </div>
