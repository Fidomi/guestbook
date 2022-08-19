import { Injectable } from '@angular/core';
import jwt_decode, { JwtPayload } from 'jwt-decode';

@Injectable({
  providedIn: 'root'
})

export class TokenStorageService {
  constructor() { }

  public signOut(): void {
    window.sessionStorage.clear();
  }

  public saveToken(token: string): void {
    window.sessionStorage.removeItem("token");
    window.sessionStorage.setItem("token", token);
  }

  public getToken(): string | null {
    return window.sessionStorage.getItem("token");
  }

  public getUserName() : string | null {
    let user = null;
    try {
      const token = window.sessionStorage.getItem("token");
      if(typeof token === "string"){
        const decoded = jwt_decode<JwtPayload>(token);
        user = (decoded as any).username;
      } else {
       throw new Error("Vous n'êtes pas authentifié.")
      }
    } catch(e) {
      console.error(e);
    }
    return user;
  }

}
