<form action="{{ route('users.update', $user->id) }}" method="POST" id="user_form" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div id="user_tab" class="mt-3">
        <h1>Preencha o formulário</h1>
        <input type="hidden" name="id" id="user_id" value="{{ $user->id }}">

        <div class="row mt-8">
            <div class="col-lg-4 col-md-4 col-sm-12 pe-3">
                <label for="user_name">Nome Completo</label>
                <input type="text" class="form-control @error ('name') is-invalid @enderror"
                    id="user_name" name="name"
                    aria-describedby="user_name_feedback"
                    value="{{ $user->name }}" required>
                @error('name')
                    <div id="user_name_feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12 pe-3">
                <label for="user_phone_number">Telefone</label>
                <input type="text" class="form-control @error ('phone_number') is-invalid @enderror"
                    id="user_phone_number" name="phone_number"
                    aria-describedby="user_phone_number_feedback"
                    value="{{ $user->phone_number }}" required>
                @error('phone_number')
                    <div id="user_phone_number_feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12 pe-3">
                <label for="role_id">Perfil</label>
                <select class="form-select @error('role_id') is-invalid @enderror"
                    id="role_id" name="role_id"
                    aria-describedby="role_id_feedback">
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" @selected ($user->roles->first()->id == $role->id)>
                            {{ $role->description }}
                        </option>
                    @endforeach
                </select>
                @error('role_id')
                    <div id="role_id_feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="row mt-8">
            <div class="col-lg-4 col-md-4 col-sm-6 pe-3">
                <label for="profile_photo">Foto</label>
                <input type="file" class="form-control @error ('profile_photo') is-invalid @enderror"
                    id="profile_photo" name="profile_photo"
                    aria-describedby="profile_photo_feedback">
                @error('profile_photo')
                    <div id="profile_photo_feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6 pe-3 d-flex align-items-end">
                <img src="{{ url("storage/{$user->profile_photo}") }}"
                    id="profile_photo_upload" alt="profile image"
                    class="profile-photo me-2" width="49px" height="49px" alt="User Profile Photo">
            </div>

        </div>

        <h3 class="mt-8">Login</h3>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 pe-3">
                <label for="user_email">E-mail</label>
                <input type="email" class="form-control @error ('email') is-invalid @enderror"
                    id="user_email" name="email"
                    aria-describedby="user_email_feedback"
                    value="{{ $user->email }}" required>
                @error('email')
                    <div id="user_email_feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12 pe-3">
                <label for="password">Senha</label>
                <input type="password" class="form-control @error ('password') is-invalid @enderror"
                    id="password" name="password" aria-describedby="user_password_feedback"
                    placeholder="********">
                @error('password')
                    <div id="user_password_feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12 pe-3">
                <label for="password_confirmation">Repita a Senha</label>
                <input type="password" class="form-control @error ('password_confirmation') is-invalid @enderror"
                    id="password_confirmation" name="password_confirmation"
                    aria-describedby="user_password_confirmation_feedback"
                    placeholder="********">
                @error('password_confirmation')
                    <div id="user_password_confirmation_feedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="w-100 d-flex justify-content-end mt-5">
            <button class="btn bg-primary btn-shadow text-white m-1 finish" style="width: 136px; height: 40px;">
                Salvar
            </button>
        </div>
    </div>

</form>
