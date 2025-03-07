<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link" id="Dashboard">
        <i class="nav-icon fas fa-home"></i>
        <p>Dashboard</p>
    </a>
</li>
<li class="nav-item has-treeview" id="liMonitoring">
    <a href="#" class="nav-link" id="Monitoring">
        <i class="nav-icon fas fa-edit"></i>
        <p>
            Data Monitoring
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview ml-4">
        <li class="nav-item">
            <a href="{{ route('monitoring.keagamaan.index') }}" class="nav-link" id="DataMonitoringKeagamaan">
                <i class="nav-icon fas fa-clipboard"></i>
                <p style="font-size:15px;">Monitoring Keagamaan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('monitoring.harian.index') }}" class="nav-link" id="DataMonitoringHarian">
                <i class="nav-icon fas fa-clipboard"></i>
                <p>Monitoring Harian</p>
            </a>
        </li>
    </ul>
</li>
