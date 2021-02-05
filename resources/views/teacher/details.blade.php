



                            <div class="form-group row">
                            <label for="firstname" class="col-sm-3 col-form-label text-right">First name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="firstName" name="firstName"  placeholder="First name" 
                                value="{{isset($teacher) ? $teacher->firstName : old('firstName')}}">
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="lastname" class="col-sm-3 col-form-label text-right">Last name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last name"
                                value="{{isset($teacher) ? $teacher->lastName : old('lastName')}}">
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="gender" class="col-sm-3 col-form-label text-right">Gender</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="gender" name="gender">
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>
                            </div>
                            </div>
                            <div class="form-group row mb-2">
                            <label for="dob" class="col-sm-3 col-form-label text-right">Date of Birth</label>
                            <div class="col-sm-6">
                                <input type="date" id="dob" name="dateOfBirth" class="form-control"
                                value="{{isset($teacher) ? $teacher->dateOfBirth : old('dateOfBirth')}}">
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
                            <label for="mobilePhoneNo" class="col-sm-3 col-form-label text-right">Mobile Phone No</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="mobilePhoneNo" id="mobilePhoneNo" 
                                value="{{isset($teacher) ? $teacher->mobilePhoneNo : old('mobilePhoneNo')}}">
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="homePhoneNo" class="col-sm-3 col-form-label text-right">Home Phone No</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="homePhoneNo" name="homePhoneNo" 
                                value="{{isset($teacher) ? $teacher->homePhoneNo : old('homePhoneNo')}}">
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="emergencyContact" class="col-sm-3 col-form-label text-right">Emergency Contact Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="emergencyContact" name="emergencyContact" 
                                value="{{isset($teacher) ? $teacher->emergencyContact : old('emergencyContact')}}">
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="emergencyPhoneNo" class="col-sm-3 col-form-label text-right">Emergency Phone No</label>
                            <div class="col-sm-6">
                                <input type="tel" class="form-control" id="emergencyPhoneNo" name="emergencyPhoneNo" 
                                value="{{isset($teacher) ? $teacher->emergencyPhoneNo : old('emergencyPhoneNo')}}">
                            </div>
                            </div>
                            <div class="form-group row">
                            <label for="mothertel" class="col-sm-3 col-form-label text-right">Emergency Relation</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="mothertel" name="emergencyRelation" placeholder="Enter number"
                                value="{{isset($teacher) ? $teacher->emergencyRelation : old('emergencyRelation')}}">
                            </div>
                            </div>
                            