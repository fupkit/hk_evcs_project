import { Component, OnInit, Inject } from '@angular/core';
import { ApiService } from 'src/app/api-service.service';
import { DataShareService } from 'src/app/data-share.service';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { MAT_DIALOG_DATA, MatSnackBar } from '@angular/material';
import { Station } from '../station';
import { BodyComponent } from 'src/app/body/body.component';

@Component({
  selector: 'app-update-dialog',
  templateUrl: './update-dialog.component.html',
  styleUrls: ['./update-dialog.component.scss']
})
export class UpdateDialogComponent implements OnInit {
  language: string = 'EN';
  updateForm: FormGroup;
  station: Station;
  constructor(private service: ApiService,
    private share: DataShareService,
    @Inject(MAT_DIALOG_DATA) public data,
    private fb: FormBuilder,
    private snackBar: MatSnackBar) { }

  ngOnInit() {
    this.station = this.data.station;
    console.log(this.station);
    this.share.sharedLang.subscribe((lang) => {
      this.language = lang.toUpperCase();
    });
    this.updateForm = this.fb.group({
      lang: [this.station.lang],
      location: [this.station.location, Validators.required],
      lat: [this.station.lat, Validators.required],
      lng: [this.station.lng, Validators.required],
      type: [this.station.type, Validators.required],
      districtL: [this.station.districtL, Validators.required],
      districtS: [this.station.districtS, Validators.required],
      address: [this.station.address, Validators.required],
      provider: [this.station.provider, Validators.required],
      parkingNo: [this.station.parkingNo, Validators.required],
      img: [this.station.img, Validators.required],
    });
  }

  updateStation() {
    console.log(this.updateForm.value);
    let sta: Station = this.updateForm.value;
    this.service.update(this.station.id, sta).subscribe(res=>{
      console.log(res);
      let a = JSON.stringify(res);
      let r = JSON.parse(a);
      this.snackBar.open(r.message);
    });
  }

  getAreas() {
    if(this.language === 'EN') {
      return BodyComponent.en_areas;
    } else {
      return BodyComponent.tc_areas;
    }
  }

  getDistricts() {
    if(this.language === 'EN') {
      return BodyComponent.en_districts;
    } else {
      return BodyComponent.tc_districts;
    }
  }

}
