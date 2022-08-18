import { Component } from '@angular/core';
import { FormGroup,FormControl } from '@angular/forms';

@Component({
  selector: 'app-user-login-editor',
  templateUrl: './user-login-editor.component.html',
  styleUrls: ['./user-login-editor.component.sass']
})

export class UserLoginEditorComponent {
  email = new FormControl('');
  password = new FormControl('');

  userLoginForm = new FormGroup({
    email : new FormControl(''),
    password : new FormControl('')
  })

  onSubmit() {
    // TODO: Use EventEmitter with form value
    console.warn(this.userLoginForm.value);
  }
}
