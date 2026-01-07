@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Clinic In-charge Dashboard</h1>
    </div>

    <div class="row mb-4">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-primary">
                <div class="card-body">
                    <h5 class="card-title">Import Patients</h5>
                    <p class="card-text">Upload Students data via Excel file.</p>
                    <a href="{{ route('admin.imports.patients.form') }}" class="btn btn-primary">Go to Import</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-success">
                <div class="card-body">
                    <h5 class="card-title">Import Medical Histories</h5>
                    <p class="card-text">Upload medical history data via Excel file.</p>
                    <a href="{{ route('admin.imports.medical_histories.form') }}" class="btn btn-success">Go to Import</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-primary text-white shadow h-100">
                <div class="card-body">
                    <h5>Total Doctors</h5>
                    <h2>{{ $totalStaff ?? 0 }}</h2>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-success text-white shadow h-100">
                <div class="card-body">
                    <h5>Total Students</h5>
                    <h2>{{ $totalPatients ?? 0 }}</h2>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-info text-white shadow h-100">
                <div class="card-body">
                    <h5>Total Users</h5>
                    <h2>{{ $totalUsers ?? 0 }}</h2>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-warning text-white shadow h-100">
                <div class="card-body">
                    <h5>Total Clinic Visits</h5>
                    <h2>{{ $totalClinicVisits ?? 0 }}</h2>
                </div>
            </div>
        </div>

    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-gray-800">Monthly Trends (Last 12 Months)</h6>
        </div>
        <div class="card-body">
            <canvas id="monthlyChart" height="100"></canvas>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('monthlyChart').getContext('2d');

const months = {!! json_encode($months ?? []) !!};
const courseData = {!! json_encode($courseData ?? []) !!};

const datasets = Object.keys(courseData).map((course,index)=>{
    const colors = ['#4e73df','#1cc88a','#36b9cc','#f6c23e','#e74a3b','#858796','#23a8f2','#a728f0'];
    return {
        label: course+' Visits',
        data: courseData[course],
        borderColor: colors[index%colors.length],
        backgroundColor: colors[index%colors.length]+'33',
        tension:0.3,
        fill:true
    };
});

let monthlyChart = new Chart(ctx,{
    type:'line',
    data:{ labels:months, datasets:datasets },
    options:{ 
        responsive:true, 
        plugins:{ legend:{ position:'top' } }, 
        scales:{ y:{ beginAtZero:true, stepSize:1 } } 
    }
});

function updateStats(){
    fetch("{{ route('admin.stats') }}")
    .then(res=>res.json())
    .then(data=>{
        document.querySelector('.bg-primary h2').textContent = data.totalStaff;
        document.querySelector('.bg-success h2').textContent = data.totalPatients;
        document.querySelector('.bg-info h2').textContent = data.totalUsers;
        document.querySelector('.bg-warning h2').textContent = data.totalClinicVisits;
    })
    .catch(err=>console.error('Error updating stats:',err));
}

function updateChart(){
    fetch("{{ route('admin.chart') }}")
    .then(res=>res.json())
    .then(data=>{
        monthlyChart.data.labels = data.months;
        const newDatasets = Object.keys(data.courseData).map((course,index)=>{
            const colors = ['#4e73df','#1cc88a','#36b9cc','#f6c23e','#e74a3b','#858796','#23a8f2','#a728f0'];
            return {
                label: course+' Visits',
                data: data.courseData[course],
                borderColor: colors[index%colors.length],
                backgroundColor: colors[index%colors.length]+'33',
                tension:0.3,
                fill:true
            };
        });
        monthlyChart.data.datasets = newDatasets;
        monthlyChart.update();
    })
    .catch(err=>console.error('Error updating chart:',err));
}

setInterval(()=>{
    updateStats();
    updateChart();
},10000);
</script>
@endsection
