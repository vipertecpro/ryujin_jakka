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
                @foreach($user->toArray() as $userColumn => $userValue)
                    <tr>
                        <td class="fw-bold text-gray-600 text-start w-25">
                            {{ Str::of($userColumn)->ucfirst() }}
                        </td>
                        <td class="fw-bold text-gray-800 text-start">
                            {{ $userValue }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-default-layout>