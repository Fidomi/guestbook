import { Component, OnInit } from '@angular/core';
import { TokenStorageService } from "./services/token-storage.service";
import { Observable} from "rxjs";
import {UserType} from "./models/user";
import {AuthenticationService} from "./services/authentication.service";

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.sass']
})
export class AppComponent implements OnInit {
  title = 'Guestbook';
  loggedIn : boolean = false;
  currentUser: UserType | null = null;

  constructor(private authService : AuthenticationService, private tokenstorage: TokenStorageService ){
    this.authService.isUserLoggedIn().subscribe((value : boolean) => {
      this.loggedIn = value;
    })
    this.authService.getCurrentUser().subscribe((value: UserType | null) => {
      this.currentUser = value;
    })
  }

  async checkAlreadyLoggedin() {
    await this.authService.getCurrentUser().subscribe({
      next:(value: UserType | null) => {
        console.log(value);
        this.currentUser = value;
      },
      error: (err)=>{console.error(err)},
      complete: ()=>{this.loggedIn = this.currentUser ? true : false}}
    )
    }

  logout() {
    this.tokenstorage.signOut();
    this.loggedIn = false;
  }

  ngOnInit(): void {
    this.checkAlreadyLoggedin();
  }
}
