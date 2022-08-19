import { Component, OnInit } from '@angular/core';
import {TokenStorageService} from "../../services/token-storage.service";
import {AuthenticationService} from "../../services/authentication.service";

@Component({
  selector: 'app-user-details',
  templateUrl: './user-details.component.html',
  styleUrls: ['./user-details.component.sass']
})
export class UserDetailsComponent implements OnInit {

  constructor(private tokenstorage: TokenStorageService, private authService : AuthenticationService) { }

  ngOnInit(): void {
  }

}
