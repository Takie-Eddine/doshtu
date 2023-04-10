<div class="card-body">
    <form action="{{ URL::current() }}" method="GET">
    <div class="row">
        {{-- <div class="col-2">
            <div class="form-group">
                <input type="text" name="keyword" value="{{ old('keyword', request()->input('keyword')) }}" class="form-control" placeholder="Search here">
            </div>
        </div> --}}
        <div class="col-2">
            <div class="form-group">
                <select name="status" class="form-control">
                    <option value="">---</option>
                    <option value="paid" {{ old('status', request()->input('status')) == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="unpaid" {{ old('status', request()->input('status')) == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                    <option value="expired" {{ old('status', request()->input('status')) == 'expired' ? 'selected' : '' }}>Expired</option>
                </select>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <select name="sort_by" class="form-control">
                    <option value="">---</option>
                    <option value="id" {{ old('sort_by', request()->input('sort_by')) == 'id' ? 'selected' : '' }}>ID</option>
                    <option value="started_date" {{ old('sort_by', request()->input('sort_by')) == 'started_date' ? 'selected' : '' }}>Started Date</option>
                    <option value="ended_date" {{ old('sort_by', request()->input('sort_by')) == 'ended_date' ? 'selected' : '' }}>Ended Date</option>
                </select>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <select name="order_by" class="form-control">
                    <option value="">---</option>
                    <option value="asc" {{ old('order_by', request()->input('order_by')) == 'asc' ? 'selected' : '' }}>Ascending</option>
                    <option value="desc" {{ old('order_by', request()->input('order_by')) == 'desc' ? 'selected' : '' }}>Descending</option>
                </select>
            </div>
        </div>
        <div class="col-1">
            <div class="form-group">
                <select name="limit_by" class="form-control">
                    <option value="">---</option>
                    <option value="10" {{ old('limit_by', request()->input('limit_by')) == '10' ? 'selected' : '' }}>10</option>
                    <option value="20" {{ old('limit_by', request()->input('limit_by')) == '20' ? 'selected' : '' }}>20</option>
                    <option value="50" {{ old('limit_by', request()->input('limit_by')) == '50' ? 'selected' : '' }}>50</option>
                    <option value="100" {{ old('limit_by', request()->input('limit_by')) == '100' ? 'selected' : '' }}>100</option>
                </select>
            </div>
        </div>
        <div class="col-3"></div>
        <div class="col-1">
            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-link">Search</button>
            </div>
        </div>
    </div>
    </form>
</div>
