

                            <div class="form-group row">
                            <label for="firstname" class="col-sm-3 col-form-label text-right">First name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="firstName" name="firstName"  placeholder="First name" 
                                value="{{isset($student) ? $student->firstName : old('firstName')}}">
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="lastname" class="col-sm-3 col-form-label text-right">Last name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last name"
                                value="{{isset($student) ? $student->lastName : old('lastName')}}">
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="gender" class="col-sm-3 col-form-label text-right">Gender</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="gender" name="gender">
                                    <option>Boy</option>
                                    <option>Girl</option>
                                </select>
                            </div>
                            </div>
                            <div class="form-group row mb-2">
                            <label for="dob" class="col-sm-3 col-form-label text-right">Date of Birth</label>
                            <div class="col-sm-6">
                                <input type="date" id="dob" name="dateOfBirth" class="form-control"
                                value="{{isset($student) ? $student->dateOfBirth : old('dateOfBirth')}}">
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="campus" class="col-sm-3 col-form-label text-right">Campus</label>
                            <div class="col-sm-4">
                                <select class="form-control" id="campus" name="campus">
                                    <option>Bernardin</option>
                                    <option>Buswell</option>
                                    <option>Curepipe</option>
                                </select>
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="class" class="col-sm-3 col-form-label text-right">Class</label>
                            <div class="col-sm-4">
                                <select class="form-control" id="class" name="class">
                                    <option>Daycare</option>
                                    <option>Lower Reception</option>
                                    <option>Upper Reception</option>
                                    <option>Class 1</option>
                                    <option>Class 2</option>
                                    <option>Class 3</option>
                                    <option>Class 4</option>
                                    <option>Class 5</option>
                                    <option>Class 6</option>
                                </select>
                            </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                            <label for="fatherfirstname" class="col-sm-3 col-form-label text-right">Father's First name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="fatherFirstName" id="fatherFirstName" placeholder="Father's first name"
                                value="{{isset($student) ? $student->fatherFirstName : old('fatherFirstName')}}">
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="mothersfirstname" class="col-sm-3 col-form-label text-right">Mother's First name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="mothersfirstname" name="motherFirstName" placeholder="Mothers's first name"
                                value="{{isset($student) ? $student->motherFirstName : old('motherFirstName')}}">
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="familyname" class="col-sm-3 col-form-label text-right">Last name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="familyname" name="familyLastName" placeholder="Family name"
                                value="{{isset($student) ? $student->familyLastName : old('familyLastName')}}">
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="fathertel" class="col-sm-3 col-form-label text-right">Father's telephone</label>
                            <div class="col-sm-6">
                                <input type="tel" class="form-control" id="fathertel" name="fatherPhoneNo" placeholder="Enter number"
                                value="{{isset($student) ? $student->fatherPhoneNo : old('fatherPhoneNo')}}">
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="mothertel" class="col-sm-3 col-form-label text-right">Mother's telephone</label>
                            <div class="col-sm-6">
                                <input type="tel" class="form-control" id="mothertel" name="motherPhoneNo" placeholder="Enter number"
                                value="{{isset($student) ? $student->motherPhoneNo : old('motherPhoneNo')}}">
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="hometel" class="col-sm-3 col-form-label text-right">Home telephone</label>
                            <div class="col-sm-6">
                                <input type="tel" class="form-control" id="hometel" name="homePhoneNo" placeholder="Enter number"
                                value="{{isset($student) ? $student->homePhoneNo : old('homePhoneNo')}}">
                            </div>