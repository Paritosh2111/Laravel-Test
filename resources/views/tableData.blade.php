@foreach ($users as $data)
{{-- {{ dd($d) }} --}}
    <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{ $data->name }}</td>
        <?php
        if ($data->hobbies) {
            $hobbyIds = [];
            foreach ($data->hobbies as $hobby) {
                $hobbyIds[] = $hobby->id;
            }
            $hobbyIdsString = implode(',', $hobbyIds);
        }

        if ($data->experiences) {
            $expIds = [];
            foreach ($data->experiences as $exp) {
                $expIds[] = $exp->name;
            }
            $expIdsString = implode(',', $expIds);
        }

        ?>
        @if ($data->hobbies)
            <td>
                @foreach ($data->hobbies as $hobby)
                    {{ $hobby->name }},
                @endforeach
            </td>
        @else
            <td>No Data Available</td>
        @endif
        <td>{{ $data->email }}</td>
        <td>
            <img src="{{ asset('storage/images/' . $data->image_path) }}" alt="Image Description" width="100px">
        </td>
        <td>
            <a data-id="{{ $data->id }}" data-phone="{{ $data->phone }}" data-edu="{{ $data->education_id }}" data-company="{{ $data->company_id }}" data-name="{{ $data->name }}"
                data-hobby="{{ $hobbyIdsString }}" data-email="{{ $data->email }}" data-picture="{{ $data->image_path }}"
                data-experience="{{ $expIdsString }}" data-gender="{{ $data->gender }}" data-message="{{ $data->message }}"
                class="btn btn-primary edit_user" data-bs-toggle="modal" data-bs-target="#myModal">
                Edit
            </a>
            <a data-url="{{ route('user.delete', $data->id) }}" data-id="{{ $data->id }}"
                class="btn btn-danger delete_record">Delete</a>

            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <form id="editForm"  enctype="multipart/form-data" method="POST">
                    {{ csrf_field() }}
                    @method("POST")
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <!-- Modal content goes here -->
                                <div>
                                    <input type="hidden" name="id" class="edit_id">

                                    <div>
                                        <strong>Name :</strong>
                                        <input type="text" name="name" class="edit_name form-control">
                                        <span class="text-danger hide" id="edit_name_error">Name Field is Required with only
                                            alphabets (A-Z or a-z)</span>
                                    </div>
                                    <div>
                                        <strong>Phone :</strong>
                                        <input type="text" name="phone" class="edit_phone form-control">
                                        <span id="edit_phone_error" class="text-danger"></span>

                                    </div>
                                    <div>
                                        <strong>Gender :</strong><br>
                                        <input class="form-check-input edit_gender form-control" name="gender" type="radio"
                                            value="male" name="flexRadioDefault" id="flexRadioDefault1">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            Male
                                        </label>
                                        <input class="form-check-input edit_gender form-control" name="gender" type="radio"
                                            value="female" name="flexRadioDefault" id="flexRadioDefault2">
                                        <label class="form-check-label" for="flexRadioDefault2">
                                            Female
                                        </label>
                                    </div>
                                    <div>
                                        <strong>Hobby :</strong>
                                        @if ($hobbies)
                                            @foreach ($hobbies as $hobby)
                                                <div class="form-check">
                                                    <input class="form-check-input edit_hobby form-control" name="hobby[]"
                                                        type="checkbox" value="{{ $hobby->id }}">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        {{ $hobby->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        @endif
                                        <span class="text-danger hobby_error"></span>

                                    </div>
                                    <div>
                                        <strong>Experience :
                                            <a class="btn btn-primary rounded-circle ml-2 mb-1 edit_exp">+</a>
                                        </strong>
                                        <div id="edit_dynamic_div" class="edit_dynamic_div form-control">
                                        </div>
                                    </div>
                                    <div>
                                        <strong>Education : <span class="text-danger">*</span></strong>
                                        <select class="form-select edit_education form-control" name="education"
                                            aria-label="Default select example" required>
                                            <option selected disabled value="">Open this select menu</option>
                                            @foreach ($edus as $edu)
                                                <option value="{{ $edu->id }}">{{ $edu->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger edit_education_error"></span>
                                    </div>
                                    <div>
                                        <strong>Company : <span class="text-danger">*</span></strong>
                                        <select class="form-control form-select edit_company" name="company"
                                            aria-label="Default select example" required>
                                            <option selected disabled value="">Open this select menu</option>
                                            @foreach ($comps as $comp)
                                                <option value="{{ $comp->id }}">{{ $comp->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger edit_company_error"></span>
                                    </div>
                                    <div>
                                        <strong>Picture :</strong>
                                        <input type="file" name="image" id="image"
                                            class="form-control image" placeholder="image">
                                        <img class="edit_dynamic_image" src="" alt="Image Description"
                                            width="100px">
                                    </div>
                                    <div>
                                        <strong>Message :</strong>
                                        <input type="text" name="message" class="edit_message form-control">
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                </form>
            </div>
        </td>
    </tr>
@endforeach
