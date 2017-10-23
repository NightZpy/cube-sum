<?php
public function post_confirm() {
  $id = Input::get('service_id');
  $servicio = Service::find($id);
  // dd($servicio);
  if ($servicio != NULL) {
    if ($servicio->status_id == '6') {
      return Response::json(array('error' => '2'));
    }

    if ($servicio->driver_id == NULL && $servicio->status_id == '1') {
      $servicio = Service::update($id, array(
                  'driver_id' => Input::get('driver_id'),
                  'status_id' => '2'
                      //Up Carro
                      //,'pwd' => md5(Input::get('pwd'))
      ));
      Driver::update(Input::get('driver_id'), array('available' = '0'));

      $driverTmp = Driver::find(Input::get('driver_id'));
      Service::update($id, array(
          'car_id' => $driverTmp->car_id
              //Up Carro
              //,'pwd' => md5(Input::get('pwd'))
      ));
      // Notificar a usuario!!
      $pushMessage = 'Tu servicio ha sido confirmado!';
      /*$servicio = Service::find($id);
      $push = Push::make();
      if ($servicio->user->type == '1') {
        // iPhone
        $pushAns = $push->ios($servicio->user->uuid, $pushMessage);
      } else {
        $pushAns = $push->android($servicio->user->uuid, $pushMessage);
      }*/
      $servicio = Service::find($id);
      $push = Push::make();
      if ($servicio->user->uuid == '') {
          return Response::json(array('error' => '0'));
      }
      if ($servicio->user->type == '1') {
        // iPhone
        $result = $push->ios($servicio->user->uuid, $pushMessage, 1, 'honk.wav', 'Open', array('serviceId' => $servicio->id));
      } else {
        $result = $push->android2($servicio->user->uuid, $pushMessage, 1, 'default', 'Open', array('serviceId' => $servicio->id));        
      }
      return Response::json(array('error' => '0'));
    } else {
      return Response::json(array('error' => '1'));
    }    
  } else {
    return Response::json(array('error' => '3'));
  }
}

public function post_confirm_refactored() {
    $service = Service::find(Input::get('service_id'));

    if (!$service) {
        return Response::json(['error' => '3']);
    
    if ($service->status_id == '6')
        return Response::json(['error' => '2']);

    if ($service->user->uuid == '')
        return Response::json(['error' => '0']);

    if ($service->driver_id == NULL && $service->status_id == '1') {
        $this->updateService($service);
        $this->pushMessage($service);
        return Response::json(['error' => '0']);
    } else {
        return Response::json(['error' => '1']);
    }
    
}

private function updateService(Service $service)
{
    $driverId = Input::get('driver_id');
    Driver::update($driverId, ['available' = '0']);
    $driverTmp = Driver::find($driverId);

    Service::update($service->id, [
        'driver_id' => $driverId,
        'status_id' => '2',
        'car_id' => $driverTmp->car_id
    ]);
}

private function pushMessage(Service $service) {
    // Iphone or Android push message
    $push = Push::make();
    $pushMessage = 'Tu servicio ha sido confirmado!';
    $userUUID = $service->user->uuid;
    $serviceId = $service->id;
    if ($service->user->type == '1')
        $push->ios($userUUID, $pushMessage, 1, 'honk.wav', 'Open', compact('serviceId'));
    else
        $push->android2($userUUID, $pushMessage, 1, 'default', 'Open', compact('serviceId'));
}







