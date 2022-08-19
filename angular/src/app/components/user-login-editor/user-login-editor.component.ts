import {Component, OnInit, ViewChild, ViewContainerRef} from '@angular/core';
import { FormGroup,FormControl } from '@angular/forms';
import { TokenStorageService } from "../../services/token-storage.service";
import {AuthenticationService} from "../../services/authentication.service";
import {AuthenticationGuard} from "../../guards/authentication-guard";

@Component({
  selector: 'app-user-login-editor',
  templateUrl: './user-login-editor.component.html',
  styleUrls: ['./user-login-editor.component.sass']
})

export class UserLoginEditorComponent {

  errorMessage ?: string = "";
  loggedIn : boolean = false;

  constructor(private authService: AuthenticationService, private tokenStorage: TokenStorageService) {
    this.authService.isUserLoggedIn().subscribe((value : boolean) => {
      this.loggedIn = value;
    })
  }

  userLoginForm = new FormGroup({
    email : new FormControl(''),
    password : new FormControl('')
  })

  onSubmit() {
    let email = this.userLoginForm.value.email;
    let password = this.userLoginForm.value.password;
    try{
      if(typeof email === "string" && typeof password === "string") {
        this.authService.login(email, password).subscribe({
          next : token => {
            this.tokenStorage.saveToken(token.token);
            this.authService.setUserLoggedIn(true);
          },
          error : error => { this.errorMessage = "Erreur d'identification!"; }
        });
      }else{
        throw new Error("Email or password aren't strings");
      }
      }catch(error : any){
        this.errorMessage = error.toString();
        console.error(error);
      }
    }

}
