@php use Illuminate\Support\Str; @endphp
<x-default-layout  :title="$title">
    @section('title')
        {{ $title }}
    @endsection
    @section('breadcrumbs')
        {!! $breadcrumbs !!}
    @endsection
    <div class="card">
        <div class="card-header  p-2">
            <div class="card-title">

            </div>
            <div class="card-toolbar gap-2">
                @if(@$formData->status === 'pending')
                    <button class="btn btn-sm btn-flex btn-success" type="button" id="approveLeaveRequestBtn" data-bs-toggle="modal" data-bs-target="#approveLeaveRequestModal">
                        <i class="fa fa-check-circle"></i>
                        Approve
                    </button>
                    <button class="btn btn-sm btn-flex btn-danger" id="rejectLeaveRequestBtn" data-bs-toggle="modal" data-bs-target="#rejectLeaveRequestModal">
                        <i class="fa fa-xmark-circle"></i> Reject
                    </button>
                    <a href="{{ route('leaveRequests.cancelLeaveRequest',[@$formData->id]) }}" class="btn btn-sm btn-flex btn-light-secondary" id="cancelLeaveRequestBtn">
                        <i class="fa fa-trash"></i> Cancel
                    </a>
                @endif
            </div>
        </div>
        <div class="card-body p-2">
            <table class="table align-middle table-row-dashed table-bordered gy-3">
                <tbody>
                <tr>
                    <td class="fw-bold text-gray-600 text-start w-150px">
                        Applied At
                    </td>
                    <td class="fw-bold text-gray-800 text-start">
                        {{ @$formData->created_at ?? '-' }}
                    </td>
                </tr>
                    <tr>
                        <td class="fw-bold text-gray-600 text-start w-150px">
                            Applied By
                        </td>
                        <td class="fw-bold text-gray-800 text-start">
                            {{ @$formData->employee->user->name ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-gray-600 text-start">
                            Leave Type
                        </td>
                        <td class="fw-bold text-gray-800 text-start">
                            {{ @$formData->leaveType->name ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-gray-600 text-start">
                            Status
                        </td>
                        <td class="fw-bold text-gray-800 text-start">
                            {{ @$formData->status ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-gray-600 text-start">
                            Approved At
                        </td>
                        <td class="fw-bold text-gray-800 text-start">
                            {{ @$formData->approved_at ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-gray-600 text-start">
                            Approved By
                        </td>
                        <td class="fw-bold text-gray-800 text-start">
                            {{ @$formData->approvedBy->user->name ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-gray-600 text-start">
                            Approved Remarks
                        </td>
                        <td class="fw-bold text-gray-800 text-start">
                            {{ @$formData->approved_remarks ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-gray-600 text-start">
                            Rejected At
                        </td>
                        <td class="fw-bold text-gray-800 text-start">
                            {{ @$formData->rejected_at ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-gray-600 text-start">
                            Rejected By
                        </td>
                        <td class="fw-bold text-gray-800 text-start">
                            {{ @$formData->rejectedBy->user->name ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold text-gray-600 text-start">
                            Rejected Reason
                        </td>
                        <td class="fw-bold text-gray-800 text-start">
                            {{ @$formData->rejected_reason ?? '-' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="approveLeaveRequestModal">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('leaveRequests.approveLeaveRequest') }}" class="form" method="POST" id="kt_approve_form">
                @csrf
                @method('POST')
                <div class="modal-content">
                    <div class="modal-header p-2">
                        <h3 class="modal-title">Approve Request</h3>
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>
                    <div class="modal-body p-4">
                        <input type="hidden" name="leave_request_id" value="{{ @$formData->id }}" />
                        <input type="hidden" name="approved_by" value="{{ auth()->user()->id }}" />
                        <div class="fv-row mb-3">
                            <label for="approved_remarks" class="form-label">Remarks</label>
                            <textarea name="approved_remarks" id="approved_remarks" class="form-control form-control-sm" placeholder="Reason to approve the leave request" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer p-2">
                        <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn-sm" id="kt_approve_form_submit">
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">
                                Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="rejectLeaveRequestModal">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('leaveRequests.rejectLeaveRequest') }}" class="form" method="POST" id="kt_reject_form">
                @csrf
                @method('POST')
                <div class="modal-content">
                    <div class="modal-header p-2">
                        <h3 class="modal-title">Reject Request</h3>
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>
                    <div class="modal-body p-4">
                        <input type="hidden" name="leave_request_id" value="{{ @$formData->id }}" />
                        <input type="hidden" name="rejected_by" value="{{ auth()->user()->id }}" />
                        <div class="fv-row mb-3">
                            <label for="rejected_reason" class="form-label">Remarks</label>
                            <textarea name="rejected_reason" id="rejected_reason" class="form-control form-control-sm" placeholder="Reason to reject the leave request" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer p-2">
                        <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn-sm" id="kt_reject_form_submit">
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">
                                Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-default-layout>
