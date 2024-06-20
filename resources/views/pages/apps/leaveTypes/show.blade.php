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
                            {{ @$formData->name ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-gray-600 text-start w-25">
                            Total Days
                        </td>
                        <td class="fw-bold text-gray-800 text-start">
                            {{ @$formData->total_days ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-gray-600 text-start w-25">
                            Type
                        </td>
                        <td class="fw-bold text-gray-800 text-start">
                            {{ @$formData->type ?? '-' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-default-layout>
