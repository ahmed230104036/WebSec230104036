@extends('layouts.app')

@section('title', 'Transcript')

@section('content')
<div class="container mt-4">
    <h2>Student Transcript</h2>

    <form id="transcriptForm">
        <div class="mb-3">
            <input type="text" id="course" class="form-control" placeholder="Course Name" required>
        </div>
        <div class="mb-3">
            <input type="text" id="grade" class="form-control" placeholder="Grade" required>
        </div>
        <div class="mb-3">
            <input type="number" id="credits" class="form-control" placeholder="Credit Hours" required>
        </div>
        <button type="button" onclick="addCourse()" class="btn btn-success">Add Course</button>
    </form>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Course</th>
                <th>Grade</th>
                <th>Credit Hours</th>
            </tr>
        </thead>
        <tbody id="transcriptTable"></tbody>
    </table>
</div>

<script>
function addCourse() {
    let course = document.getElementById("course").value;
    let grade = document.getElementById("grade").value;
    let credits = document.getElementById("credits").value;

    let row = `<tr>
                <td>${course}</td>
                <td>${grade}</td>
                <td>${credits}</td>
            </tr>`;

    document.getElementById("transcriptTable").innerHTML += row;
    document.getElementById("transcriptForm").reset();
}
</script>
@endsection
