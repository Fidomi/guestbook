import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ConferencesComponent } from './components/conferences/conferences.component';
import { HomeComponent} from "./components/home/home.component";
import { ConferenceDetailsComponent} from "./components/conference-details/conference-details.component";

const routes: Routes = [
  {path: '', component:HomeComponent},
  {path: 'conferences', component:ConferencesComponent},
  {path: 'conferences/:conferenceId', component:ConferenceDetailsComponent},
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
