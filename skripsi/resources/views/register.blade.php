<form action="{{ route('register.action') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Name <span class="text-danger">*</span></label>
        <input class="form-control" type="text" name="name" value="{{ old('name') }}" />
    </div>
    <div class="mb-3">
        <label>Email <span class="text-danger">*</span></label>
        <input class="form-control" type="email" name="email" value="{{ old('email') }}" />
    </div>
    <div class="mb-3">
        <label>Password <span class="text-danger">*</span></label>
        <input class="form-control" type="password" name="password" />
    </div>
    <div class="mb-3">
        <label>Password Confirmation<span class="text-danger">*</span></label>
        <input class="form-control" type="password" name="password_confirm" />
    </div>
    <div class="mb-3">
        <label>Role<span class="text-danger">*</span></label>
        <select name="role">
            <option value="admin">admin</option>
            <option value="kasir">kasir</option>
        </select>
    </div>
    <div class="mb-3">
        <button class="btn btn-primary">Register</button>
        <a class="btn btn-danger" href="{{ route('home') }}">Back</a>
    </div>
</form>
