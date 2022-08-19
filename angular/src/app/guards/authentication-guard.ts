import { TokenStorageService } from "../services/token-storage.service";
import { UserType } from "../models/user";
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})

export class AuthenticationGuard {
  constructor(private tokenstorage : TokenStorageService) { }

  //   public currentUser(): UserType|null {
  //   if(){
  //     let token = this.tokenstorage.getToken();
  //     var payload = JSON.parse(window.atob((token as string).split('.')[1]));
  //     return {
  //       email : payload.email,
  //       firstname : payload.firstname,
  //       lastname: payload.lastname,
  //       role: payload.role,
  //       biography: payload.biography,
  //       picture: payload.picture
  //     };
  //   }
  //   return null;
  // }
  //
  // public isAdmin(): boolean {
  //   let result = false;
  //   if(this.isLoggedIn()){
  //     const currentUser = this.currentUser() as UserType;
  //     if(Array.isArray(currentUser.role)) {
  //       result = currentUser.role.some(ele => ele === "ROLE_ADMIN");
  //     }
  //   }
  //   return result;
  // }

}
