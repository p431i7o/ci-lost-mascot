        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="sidebar-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?php if(uri_string()=='cuenta')echo "active";?>" href="<?=base_url('cuenta');?>">
                            <i class="fas fa-tachometer-alt"></i> Dashboard <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if(uri_string()=='cuenta/mensajes')echo "active";?>" href="<?=base_url('cuenta/mensajes');?>">
                            <i class="fas fa-voicemail"></i> Mensajes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if(uri_string()=='cuenta/reportes')echo "active";?>" href="<?=base_url('cuenta/reportes');?>">
                            <i class="fas fa-stream"></i> Mis reportes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if(uri_string()=='cuenta/reportes/nuevo')echo "active";?>" href="<?=base_url('cuenta/reportes/nuevo');?>">
                            <i class="fas fa-file-alt"></i> Nuevo Reporte
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="#">Reports
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Integrations
                        </a>
                    </li> -->
                </ul>

                <!-- <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Saved reports</span>
                    <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
                        <span data-feather="plus-circle"></span>
                    </a>
                </h6>
                <ul class="nav flex-column mb-2">
                  <li class="nav-item">
                    <a class="nav-link" href="#">
                      <span data-feather="file-text"></span>
                      Current month
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">
                      <span data-feather="file-text"></span>
                      Last quarter
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">
                      <span data-feather="file-text"></span>
                      Social engagement
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">
                      <span data-feather="file-text"></span>
                      Year-end sale
                    </a>
                  </li>
                </ul> -->
            </div>
        </nav>