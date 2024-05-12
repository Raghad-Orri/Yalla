import '/backend/api_requests/api_calls.dart';
import '/flutter_flow/flutter_flow_util.dart';
import 'authorized_r_e_widget.dart' show AuthorizedREWidget;
import 'package:flutter/material.dart';

class AuthorizedREModel extends FlutterFlowModel<AuthorizedREWidget> {
  ///  State fields for stateful widgets in this page.

  // State field(s) for TextField widget.
  FocusNode? textFieldFocusNode;
  TextEditingController? textController;
  String? Function(BuildContext, String?)? textControllerValidator;
  // Stores action output result for [Backend Call - API (authREG)] action in Button widget.
  ApiCallResponse? apiResultr8b;

  @override
  void initState(BuildContext context) {}

  @override
  void dispose() {
    textFieldFocusNode?.dispose();
    textController?.dispose();
  }
}
