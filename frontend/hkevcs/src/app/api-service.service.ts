import { Injectable } from '@angular/core';
import { environment } from "../environments/environment"
import { HttpClient, HttpParams } from "@angular/common/http";
@Injectable({
  providedIn: 'root'
})
export class ApiService {
  basePath: string;
  constructor(private http: HttpClient) {
    this.basePath = environment.apiEndPoint;
  }

  getAll() {
    return this.http.get(this.basePath + 'station.php');
  }

  getById(id: number) {
    return this.http.get(this.basePath + 'station.php' + '/' + id);
  }

  search(loc: string) {
    let params = new HttpParams()
      .set('loc', loc);

    return this.http.get(this.basePath + 'station.php', {
      params: params
    });
  }

  insert(station: any) {
    let params = new HttpParams()
      .set('station', JSON.stringify(station));
    return this.http.post(this.basePath + 'station.php', params);
  }

  update(id: number, station: any) {
    let params = new HttpParams()
      .set('station', JSON.stringify(station));
    return this.http.put(this.basePath + 'station.php' + '/' + id, params);
  }

  delete(id: number) {
    return this.http.delete(this.basePath + 'station.php' + '/' + id);
  }

  getDistrict(lang) {
    let params = new HttpParams()
      .set('lang', JSON.stringify(lang));
    return this.http.get(this.basePath + 'district.php', { params: params });
  }

  getArea(lang) {
    let params = new HttpParams()
    .set('lang', JSON.stringify(lang));
  return this.http.get(this.basePath + 'district.php/area', { params: params });
  }

}
