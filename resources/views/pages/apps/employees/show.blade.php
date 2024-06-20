@php use Illuminate\Support\Str; @endphp
<x-default-layout  :title="$title">
    @section('title')
        {{ $title }}
    @endsection
    @section('breadcrumbs')
        {!! $breadcrumbs !!}
    @endsection
    <div class="card">
        <div class="card-body">
            <table class="table align-middle table-row-dashed table-bordered gy-3">
                <tbody>
                    <tr>
                        <td class="fw-bold text-gray-600 text-start w-25">
                            Name
                        </td>
                        <td class="fw-bold text-gray-800 text-start">
                            {{ @$formData->user->name ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-gray-600 text-start w-25">
                            Email
                        </td>
                        <td class="fw-bold text-gray-800 text-start">
                            {{ @$formData->user->email ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-gray-600 text-start w-25">
                            Designation
                        </td>
                        <td class="fw-bold text-gray-800 text-start">
                            {{ @$formData->designation->name ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-gray-600 text-start w-25">
                            Department
                        </td>
                        <td class="fw-bold text-gray-800 text-start">
                            {{ @$formData->department->name ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-gray-600 text-start w-25">
                            Branch
                        </td>
                        <td class="fw-bold text-gray-800 text-start">
                            {{ @$formData->branch->name ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-gray-600 text-start w-25">
                            Date of birth
                        </td>
                        <td class="fw-bold text-gray-800 text-start">
                            {{ @$formData->date_of_birth ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-gray-600 text-start w-25">
                            Date of joining
                        </td>
                        <td class="fw-bold text-gray-800 text-start">
                            {{ @$formData->date_of_joining ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-gray-600 text-start w-25">
                            Pan number
                        </td>
                        <td class="fw-bold text-gray-800 text-start">
                            {{ @$formData->pan_number ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-gray-600 text-start w-25">
                            Employee code
                        </td>
                        <td class="fw-bold text-gray-800 text-start">
                            {{ @$formData->employee_code ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-gray-600 text-start w-25">
                            Personal Number
                        </td>
                        <td class="fw-bold text-gray-800 text-start">
                            {{ @$formData->personal_number ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-gray-600 text-start w-25">
                            Current Address
                        </td>
                        <td class="fw-bold text-gray-800 text-start">
                            {{ @$formData->current_address ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-gray-600 text-start w-25">
                            Permanent Address
                        </td>
                        <td class="fw-bold text-gray-800 text-start">
                            {{ @$formData->permanent_address ?? '-' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-default-layout>
