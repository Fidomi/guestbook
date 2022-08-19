import { NgModule } from '@angular/core';
import { HttpClientModule } from '@angular/common/http';
import { BrowserModule } from '@angular/platform-browser';
import { AppRoutingModule } from './app-routing.module';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import { AppComponent } from './app.component';
import { FontAwesomeModule } from "@fortawesome/angular-fontawesome";
import { ConferencesComponent } from './components/conferences/conferences.component';
import { ConferenceDetailsComponent } from './components/conference-details/conference-details.component';
import { CommentsListComponent } from './components/comments-list/comments-list.component';
import { UserDetailsComponent } from './components/user-details/user-details.component';
import { UserLoginEditorComponent } from './components/user-login-editor/user-login-editor.component';
import { UserSignUpComponent } from './components/user-sign-up/user-sign-up.component';
import {HomeComponent} from "./components/home/home.component";


@NgModule({
  declarations: [
    AppComponent,
    ConferencesComponent,
    ConferenceDetailsComponent,
    CommentsListComponent,
    UserDetailsComponent,
    UserLoginEditorComponent,
    UserSignUpComponent,
    HomeComponent
  ],
  imports: [
    BrowserModule,
    HttpClientModule,
    AppRoutingModule,
    FontAwesomeModule,
    FormsModule,
    ReactiveFormsModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})

// @ts-ignore
export class AppModule { }
